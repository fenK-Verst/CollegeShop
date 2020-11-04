<?php


namespace App;


use App\Di\Container;
use App\Http\Response;
use App\Routing\Route;
use App\Routing\Router;
use Exception;

class Kernel
{
    private Router $router;

    private Container $container;

    private Config $config;

    /**
     * Kernel constructor.
     *
     * @param Router    $router
     * @param Container $container
     * @param Config    $config
     */
    public function __construct(Router $router, Container $container, Config $config)
    {
        $this->router = $router;
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $route = $this->router->dispatch();
        if ($route) {
            $this->runMiddlewares($route);
            $response = $this->dispatch($route);
        } else {
            $response = $this->router->getNotFoundResponse();
        }


        $response->send();
    }

    /**
     * @param Route $route
     *
     * @return Response
     * @throws Exception
     */
    private function dispatch(Route $route): Response
    {
        return $this->container->getInjector()
            ->callMethod(
                $route->getController(),
                $route->getMethod()
            );
    }

    /**
     * @param Route $route
     */
    private function runMiddlewares(Route $route)
    {

        $middlewares = $this->config->getMiddlewares();
        foreach ($middlewares as $middlewareClass) {
            try {
                $middleware = $this->container->get($middlewareClass);
                $middleware->run($route);
            } catch (Di\Exceptions\ClassNotExistsException $e) {
            }
        }
    }


}