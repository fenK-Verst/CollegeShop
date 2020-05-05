<?php


namespace App;


use App\Di\Container;
use App\Http\Response;
use App\Routing\Route;
use App\Routing\Router;

class Kernel
{
    private Router $router;

    private Container $container;

    private Config $config;

    public function __construct(Router $router, Container $container, Config $config)
    {
        $this->router = $router;
        $this->container = $container;
        $this->config = $config;
    }

    public function run()
    {

        $route = $this->router->dispatch();

        $this->runMiddlewares($route);

        $response = $this->dispatch($route);

        $response->send();
    }
    private function dispatch(Route $route): Response
    {
        return $this->container->getInjector()->callMethod(
            $route->getController(),
            $route->getMethod()
        );
    }
    private function runMiddlewares(Route $route)
    {
        $middlewares = $this->config->getMiddlewares();
        foreach ($middlewares as $value){
            $middleware = $this->container->get($value);
            $middleware->run($route);
        }
    }


}