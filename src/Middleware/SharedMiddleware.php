<?php


namespace App\Middleware;


use App\Routing\Route;
use App\Service\UserService;

class SharedMiddleware implements MiddlewareInterface
{


    public function run(Route $route)
    {
        $controller = $route->getController();
        $controller->addSharedData("version", getenv("VERSION"));
    }
}