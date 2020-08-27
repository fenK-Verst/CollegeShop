<?php

namespace App\Routing;

use App\Config;
use App\Di\Container;
use App\Http\Request;
use App\Twig;
use ReflectionClass;

class Router
{
    private Config $config;
    private Request $request;
    private Container $container;
      private CustomRouter $custom_router;

    public function __construct(Config $config, Request $request, Container $container, CustomRouter $custom_router)
    {
        $this->config = $config;
        $this->request = $request;
        $this->container = $container;
        $this->custom_router = $custom_router;
    }

    public function dispatch(): Route
    {
        $route_data = $this->findRouteData();
        if (!$route_data) {
            $this->notFound();
        }
        $controller = $route_data['controller'];
        $method = $route_data['method'];
        $params = $route_data['params'];

        $controller = $this->container->get($controller);
        return new Route($controller, $method, $params);
    }
    private function findRouteData()
    {
        $route_data = $this->getRouteData();

        if (!$route_data){
            $route_data = $this->custom_router->getRouteData($this->request->getUrl());
        }
        return $route_data;
    }

    private function getRouteData(): array
    {
        $routes = $this->getRoutes();

        $url = $this->request->getUrl();

        $findedRoute = null;
        foreach ($routes as $route) {
            $routeUrl = strtolower($route['url']);

            if (!($routeUrl == $url || $routeUrl == $url . "/")) {
                continue;
            }

            $methods = @json_decode($route['params']['methods']);
            if (!$methods) {
                $findedRoute = $route;
                break;
            }
            $methods = array_map(function ($m) {
                return strtolower($m);
            }, $methods);

            $request_method = strtolower($_SERVER['REQUEST_METHOD']);

            if (in_array($request_method, $methods)) {
                $findedRoute = $route;
                break;
            }

        }
        if (!empty($findedRoute)) {
            return $findedRoute;
        }
        $findedRoute = $this->findComplicatedRoute($routes);

        return $findedRoute;
    }

    private function findComplicatedRoute(array $routes)
    {
        $route = [];
        $url = $this->request->getUrl();
        foreach ($routes as $route_data) {
            $route_params = [];

            $routeUrl = $route_data['url'];

            if (!$this->isComplicatedUrl($routeUrl)){
                continue;
            }
            $url_chunks = explode('/', $url);
            $route_key_chunks = explode('/', $routeUrl);

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
            $route['params'] = $route_params;
        }

        return $route;
    }

    private function getRoutes()
    {
        $routes = [];
        $controllers = $this->config->getControllers();

        foreach ($controllers as $controller) {
            $reflection_controller = new ReflectionClass($controller);
            $reflection_methods = $reflection_controller->getMethods();
            $controller_route = $this->getControllerRoute($reflection_controller);
            $controller_url = $controller_route["url"] ?? '';

            foreach ($reflection_methods as $method) {
                $routeData = $this->getRouteFromReflectionMethod($method, $controller_url);
                if (!is_null($routeData)) {
                    $routes[] = [
                        'url' => $routeData[0],
                        'controller' => $controller,
                        'method' => $routeData[1],
                        'params' => $routeData[2]
                    ];
                }
            }
        }
        return $routes;
    }

    private function getRouteFromReflectionMethod(\ReflectionMethod $method, string $controller_url = '')
    {
        $method_name = $method->getName();
        $doc = $method->getDocComment();
        preg_match_all('/@Route\((.*)\)/s', $doc, $finded);

        if (!$finded[1]) {
            return null;
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
        if ($url{0} != '/') {
            $url = '/' . $url;
        }

        return [
            $url,
            $method_name,
            $params
        ];
    }

    private function getControllerRoute(ReflectionClass $controller): ?array
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

    private function isComplicatedUrl(string $url): bool
    {
        return preg_match('/{.+}/im', $url, $matches);
    }

    private function assertUrlAndRouteChunk(string $url_chunk, string $route_key_chunk): bool
    {
        if (preg_match('/^{.+}$/im', $route_key_chunk, $matches) == false) {
            return $url_chunk == $route_key_chunk;
        }

        return true;
    }

    private function getRouteParam(string $url_chunk, string $route_chunk)
    {
        if (preg_match('/^{.+}$/im', $route_chunk, $matches) == false) {
            return [];
        }

        $route_chunk = preg_replace('/[{}]/im', '', $route_chunk);

        return [
            $route_chunk => $url_chunk,
        ];
    }

    private function notFound()
    {
        header('HTTP/1.0 404 Not Found', true, 404);
        /**
         * @var Twig $twig
         */
        $twig = $this->container->get(Twig::class);
        $html = $twig->render("HttpErrors/error.html.twig", [
            "code" => 404,
            "name" => 'Page not found'
        ]);
        die($html);
    }

    private function nowAllowed()
    {
        header('HTTP/1.0 405 Method Not Allowed', true, 405);
        /**
         * @var Twig $twig
         */
        $twig = $this->container->get(Twig::class);
        $html = $twig->render("HttpErrors/error.html.twig", [
            "code" => 405,
            "name" => 'Method is not allowed'
        ]);
        die($html);
    }


}