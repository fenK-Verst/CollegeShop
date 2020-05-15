<?php

namespace App\Routing;

use App\Config;
use App\Controller\UserRoutesController;
use App\Di\Container;
use App\Entity\CustomRoute;
use App\Http\Request;
use App\Repository\CustomRouteRepository;
use App\Repository\ImageRepository;
use App\Twig;

class Router
{
    private Config $config;
    private Request $request;
    private Container $container;

    public function __construct(Config $config, Request $request, Container $container)
    {
        $this->config = $config;
        $this->request = $request;
        $this->container = $container;
    }

    public function dispatch(): Route
    {
        $route_data = $this->findRouteData();
        if (!$route_data) {
           $this->notFound();

        }
        $controller = $route_data[0];
        $method = $route_data[1];
        $params = $route_data[2];

        $controller = $this->container->get($controller);
        return new Route($controller, $method, $params);
    }
    private function findRouteData()
    {
        $route_data = $this->getRouteData();
        if (!$route_data){
            $route_data = $this->getUserRouteData();
        }
        return $route_data;
    }
    private function getRouteData(): array
    {

        $routes = $this->getRoutes();
        $url = $this->request->getUrl();
        $route = $routes[$url] ?? $routes[$url . "/"] ?? [];
        if (!empty($route)) {
            return $route;
        }

        foreach ($routes as $key => $route_data) {
            $route_params = [];

            $url_chunks = explode('/', $url);
            $route_key_chunks = explode('/', $key);

            $url_chunks = array_filter($url_chunks);
            $route_key_chunks = array_filter($route_key_chunks);


            if (count($url_chunks) != count($route_key_chunks)) {
                continue;
            }

            for ($i = 1; $i <= count($url_chunks); $i++) {
                $url_chunk = $url_chunks[$i];
                $route_key_chunk = $route_key_chunks[$i];

                $url_chunk = trim($url_chunk, '"');
                $route_key_chunk = trim($route_key_chunk, '"');


                $match = $this->assertUrlAndRouteChunk($url_chunk, $route_key_chunk);
                if (!$match) {
                    continue 2;
                }

                $param = $this->getRouteParam($url_chunk, $route_key_chunk);

                $route_params = array_replace($route_params, $param);
            }
            $route = $route_data;
            $route[2] = $route_params;

        }
        return $route;
    }

    private function getRoutes()
    {
        $routes = [];
        $controllers = $this->config->getControllers();
        foreach ($controllers as $controller) {
            $reflection_controller = new \ReflectionClass($controller);
            $reflection_methods = $reflection_controller->getMethods();
            $controller_route = $this->getControllerRoute($reflection_controller);
            $controller_url = $controller_route["url"] ?? '';
            foreach ($reflection_methods as $method) {
                $method_name = $method->getName();
                $doc = $method->getDocComment();
                preg_match_all('/@Route\((.*)\)/s', $doc, $finded);

                if (!$finded[1]) {
                    continue;
                }

                $route_params = explode(',', $finded[1][0]);
                $route_url = $route_params[0];

                $params = [];
                for ($i = 1; $i < count($route_params); $i++) {
                    $param = $route_params[$i];
                    $param = explode("=", $param);

                    $key = trim($param[0]);
                    $value = trim($param[1], "\"");
                    $params[$key] = $value;
                }
                $controller_url = trim($controller_url, '"');
                $route_url = trim($route_url, '"');
                $url = trim($controller_url . $route_url, '"');
                $routes[$url] = [
                    $controller,
                    $method_name,
                    $params
                ];

            }
        }
        return $routes;
    }

    private function getControllerRoute(\ReflectionClass $controller): ?array
    {
        $doc = $controller->getDocComment();
        preg_match_all('/@Route\((.*)\)/s', $doc, $finded);

        if (!$finded[1]) {
            return [];
        }

        $params = explode(',', $finded[1][0]);
        $url = $params[0];
        $result = [
            "url" => trim($url, "\"")
        ];
        for ($i = 1; $i < count($params); $i++) {
            $param = $params[$i];
            $param = explode("=", $param);

            $key = trim($param[0]);
            $value = trim($param[1], "\"");
            $result[$key] = $value;

        }
        return $result;
    }

    private function notFound()
    {
        header('HTTP/1.0 404 Not Found', true, 404);
        /**
         * @var Twig $twig
         */
        $twig = $this->container->get(Twig::class);
        $html = $twig->render("HttpErrors/error.html.twig", [
            "code"=>404,
            "name"=>'Page not found'
        ]);
        die($html);
    }

    private function assertUrlAndRouteChunk(string $url_chunk, string $route_key_chunk)
    {
        if (preg_match('/^{.+}$/im', $route_key_chunk, $matches) == false) {
            return $url_chunk == $route_key_chunk;
        }

        return true;
    }

    private function getRouteParam(string $url_chunk, string $route_chunk) {
        if (preg_match('/^{.+}$/im', $route_chunk, $matches) == false) {
            return [];
        }

        $route_chunk = preg_replace('/[{}]/im', '', $route_chunk);

        return [
            $route_chunk => $url_chunk,
        ];
    }

    private function getUserRouteData() : ?array
    {
        $route_data = null;
        $route_repository = $this->container->get(CustomRouteRepository::class);
        $url = $this->request->getUrl();
        $routes = $route_repository->findBy([
            "real_url"=>$url
        ]);
        if (!empty($routes)){
            /**
             * @var CustomRoute $route
             */
            $route = $routes[0];
            $route_params = json_decode($route->getParams(), true);
            $template = $route->getTemplate();
            $vars = json_decode($template->getParams(),true);

            $params = [];
            foreach ($route_params as $key => &$route_param) {

                $var = $vars[$key];
                if (!$var["type"]) {
                   throw new \Error('Ошибка типизации. Обратитесь к разработчику');
                }
                switch ($var["type"]) {
                    case "html":
                    case "text":
                        $params[$key] = $route_param;
                        break;
                    case "image":
                        $is_multiply = $var["multiply"] ?? false;
                        $image_repository = $this->container->get(ImageRepository::class);
                        if (!$is_multiply) {
                            $image = $image_repository->find($route_param);
                            if (!$image) {
                                $route_param = null;
                            }
                            $params[$key] = $image;
                        } else {
                            $images = $image_repository->findBy([
                                "id"=>$route_param]);
                            $params[$key] = $images;
                        }

                }
            }
            $route_data = [
                UserRoutesController::class,
                "index",
                [
                    "template_name"=>$route->getTemplate()->getPath(),
                    "params"=>$params
                ]
            ];
        }

        return $route_data;
    }
}