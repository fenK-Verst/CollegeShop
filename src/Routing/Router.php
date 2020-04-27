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
        if (!$route_data){
            $this->notFound();
        }
        $controller = $route_data[0];
        $method = $route_data[1];
        $params = $route_data[2];

        $controller = $this->container->get($controller);
        return new Route($controller, $method);
    }

    private function findRouteData(): array
    {

        $url = $this->request->getUrl();
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

                if (!$finded[1]) continue;

                $route_params = explode(',', $finded[1][0]);
                $route_url = $route_params[0];


                if (!($controller_url.trim($route_url, "\"") == $url ||
                    $controller_url.trim($route_url, "\"") == $url."/")) continue;

                $params = [];
                for ($i=1;$i<count($route_params);$i++){
                    $param = $route_params[$i];
                    $param = explode("=",$param);

                    $key = trim($param[0]);
                    $value = trim($param[1], "\"");
                    $params[$key] = $value;

                }
                return [
                    $controller,
                    $method_name,
                    $params
                ];

            }
        }


        return [];
    }
    private function getControllerRoute(\ReflectionClass $controller):?array
    {
        $doc = $controller->getDocComment();
        preg_match_all('/@Route\((.*)\)/s', $doc, $finded);

        if (!$finded[1]) return [];

        $params = explode(',', $finded[1][0]);
        $url = $params[0];
         $result = [
            "url"=>trim($url, "\"")
        ];
        for ($i=1;$i<count($params);$i++){
            $param = $params[$i];
            $param = explode("=",$param);

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
}