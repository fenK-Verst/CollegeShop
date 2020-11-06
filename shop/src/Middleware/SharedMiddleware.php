<?php


namespace App\Middleware;


use App\Routing\Route;
use App\Service\UserService;

class SharedMiddleware implements MiddlewareInterface
{
    public function run(Route $route)
    {
        $route->addSharedData("version", getenv("VERSION"));
    }
}