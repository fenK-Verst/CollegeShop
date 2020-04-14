<?php


namespace App;


use App\Di\Container;
use App\Routing\Route;
use App\Routing\Router;

class Kernel
{
    private $router;

    private $container;

    public function __construct(Router $router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    public function run()
    {
        $route = $this->router->dispatch();

        $response = $this->dispatch($route);

        $response->send();
    }
    private function dispatch(Route $route)
    {
        return $this->container->getInjector()->callMethod(
            $route->getController(),
            $route->getMethod()
        );
    }


}