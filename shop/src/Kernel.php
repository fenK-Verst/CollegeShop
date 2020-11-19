<?php


namespace App;


use App\Controller\AbstractController;
use App\Di\Container;
use App\Http\Response;
use App\Routing\Exceptions\NotAllowedMethodException;
use App\Routing\Route;
use App\Routing\Router;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Kernel implements KernelInterface
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
     * @throws Di\Exceptions\ClassNotExistsException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function run()
    {
        $error = null;
        $route = $this->router->dispatch();
        if ($route->getStatusCode() == 200){
            $this->runMiddlewares($route);
        }
        $response = $this->dispatch($route);
        $response->send();
    }

    /**
     * @param Route $route
     *
     * @return Response
     * @throws Di\Exceptions\ClassNotExistsException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function dispatch(Route $route): Response
    {
        try {
            $controller = $route->getController();
            /** @var AbstractController $controller */
            $controller = $this->container->get($controller);
            $controller->setSharedData($route->getSharedParams());
            $controller->setParams($route->getParams());
            return $this->container->getInjector()
                ->callMethod(
                    $controller,
                    $route->getMethod()
                );
        }catch (Exception $e){
            error_log($e);
            return $this->dispatch($this->router->getErrorRoute(500));
        }
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