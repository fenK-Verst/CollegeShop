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
        $controller = $route_data[0] ?? "App\Controller\FolderController";
        $method = $route_data[1] ?? "index";
        $params = $route_data[2];

        $controller = $this->container->get($controller);
        return new Route($controller, $method);
    }

    private function findRouteData(): array
    {
        $url = $this->request->getUrl();
        $controllers = $this->config->getControllers();
        $route_data = [];
        foreach ($controllers as $controller) {
            $reflection_controller = new \ReflectionClass($controller);
            $reflection_methods = $reflection_controller->getMethods();
            foreach ($reflection_methods as $method) {

            }
        }

        return $route_data;
    }
}