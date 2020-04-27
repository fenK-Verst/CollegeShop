<?php

namespace App\Routing;

use App\Config;
use App\Di\Container;
use App\Http\Request;

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

    private function findRouteData(): array
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
                $routes[trim($controller_url . $route_url, '"')] = [
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
        die("404");
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
}