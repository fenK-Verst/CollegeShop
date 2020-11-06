<?php

namespace App\Routing;

use App\Config;
use App\Controller\UserRoutesController;
use App\Http\Request;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Router
{
    private Config       $config;
    private Request      $request;
    private CustomRouter $custom_router;

    public function __construct(Config $config, Request $request, CustomRouter $custom_router)
    {
        $this->config = $config;
        $this->request = $request;
        $this->custom_router = $custom_router;
    }

    /**
     * @return Route|null
     */
    public function dispatch(): Route
    {
        try {
            $routes = $this->getRoutesByRequestUrl();

            if (empty($routes)) {
                $routes = $this->custom_router->getRoutesByUrl($this->request->getUrl());
            }
            if (empty($routes)) {
                return $this->getErrorRoute(404);
            }
            foreach ($routes as $route) {
                if ($this->testRouteOnRequestMethod($route)) {
                    return $route;
                }
            }
            //Есть руты с массиве, но не 1 не подошел по request_method
            return $this->getErrorRoute(405);

        } catch (\Exception $e) {
            error_log($e);
            return $this->getErrorRoute(500);
        }
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getRoutesByRequestUrl(): array
    {
        $routes = $this->getAllRoutes();

        $foundRoutes = $this->findSimpleRoutes($routes);
        //Найдены простые урлы, без сложных параметров
        if (!empty($foundRoutes)) {
            return $foundRoutes;
        }
        //Ищем дальше урлы с параметрами
        $foundRoutes = $this->findComplicatedRoute($routes);

        return $foundRoutes;
    }

    /**
     * @param array $routes
     *
     * @return array
     */
    private function findSimpleRoutes(array $routes)
    {
        $foundRoutes = [];
        $url = $this->request->getUrl();
        foreach ($routes as $route) {
            $routeUrl = strtolower($route->getUrl());

            if (!($routeUrl == $url || $routeUrl == $url . "/")) {
                continue;
            }
            $foundRoutes[] = $route;
        }
        return $foundRoutes;
    }

    /**
     * @param Route $route
     *
     * @return bool
     */
    private function testRouteOnRequestMethod(Route $route)
    {
        $methods = @json_decode($route->getParams()['methods']);
        if (!$methods) {
            return true;
        }
        $methods = array_map(function ($m) {
            return strtolower($m);
        }, $methods);

        $request_method = strtolower($_SERVER['REQUEST_METHOD']);

        if (in_array($request_method, $methods)) {
            return true;
        }
        return false;
    }

    /**
     * @param array $routes
     *
     * @return array|mixed
     */
    private function findComplicatedRoute(array $routes)
    {
        $foundRoutes = [];
        $url = $this->request->getUrl();
        foreach ($routes as $route_data) {
            /**
             * @var Route $route_data
             */
            $route_params = [];
            $routeUrl = $route_data->getUrl();

            if (!$this->isComplicatedUrl($routeUrl)) {
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
            $route->setParams($route_params);
            $foundRoutes[] = $route;
        }
        return $foundRoutes;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getAllRoutes()
    {
        $routes = [];
        $controllers = $this->config->getControllers();

        foreach ($controllers as $controller) {
            $reflection_controller = new ReflectionClass($controller);
            $reflection_methods = $reflection_controller->getMethods();

            $controller_route = $this->getControllerRoute($reflection_controller);


            foreach ($reflection_methods as $method) {
                $route = $this->getRouteFromReflectionMethod($method, $controller_route);
                if (!is_null($route)) {
                    $route->setController($controller);
                    $routes[] = $route;
                }
            }
        }

        return $routes;
    }

    private function getRouteSettingsFromDocComment(string $doc): ?array
    {
        preg_match_all('/@Route\((.*)\)/s', $doc, $found);
        if (!$found[1]) {
            return null;
        }

        $route_params = explode(',', $found[1][0]);
        $route_url = $route_params[0];
        preg_match_all('/[a-zA-Z0-9_.]*=[\"{\[][a-zA-Z0-9_{}\[\]\'\", .]*[\"}\]]/s', $found[1][0], $route_params);
        if (!empty($route_params[0])) {
            $params = $this->assetParams($route_params[0]);
        } else {
            $params = [];
        }


        return [
            'url' => $route_url,
            'params' => $params
        ];

    }

    /**
     * @param ReflectionMethod $method
     * @param Route|null       $controller_route
     *
     * @return array|null
     */
    private function getRouteFromReflectionMethod(ReflectionMethod $method, ?Route $controller_route = null): ?Route
    {
        $method_name = $method->getName();
        $doc = $method->getDocComment();

        $routeSettings = $this->getRouteSettingsFromDocComment($doc);
        if (is_null($routeSettings)) {
            return null;
        }

        $route_url = $routeSettings['url'];
        $params = $routeSettings['params'];

        if ($controller_route instanceof Route) {
            $controller_url = $controller_route->getUrl() ?? '';
        } else {
            $controller_url = '';
        }

        $controller_url = trim($controller_url, '"');
        $route_url = trim($route_url, '"');


        $url = trim($controller_url . $route_url, '"');
        if ($url[0] != '/') {
            $url = '/' . $url;
        }

        return new Route($url, $params, null, $method_name);
    }

    /**
     * @param array $route_params
     *
     * @return array
     */
    private function assetParams(array $route_params): array
    {
        $params = [];
        for ($i = 0; $i < count($route_params); $i++) {
            $param = $route_params[$i];
            $param = explode("=", $param);
            $key = trim($param[0]);
            $value = trim($param[1], "\"");
            $params[$key] = $value;
        }
        return $params;
    }

    private function getControllerRoute(ReflectionClass $controller): ?Route
    {
        $settings = $this->getRouteSettingsFromDocComment($controller->getDocComment());

        if (!$settings) {
            return null;
        }

        return new Route($settings['url'], $settings['params']);
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

    /**
     * @param int $status_code
     *
     * @return Route
     */
    public function getErrorRoute(int $status_code)
    {
        if ($status_code >= 500) {
            $status_code = 500;
        } elseif ($status_code != 200 && ($status_code < 404 || $status_code > 405)) {
            $status_code = 500;
        }
        return new Route('', [], UserRoutesController::class, "method_$status_code");
    }


}