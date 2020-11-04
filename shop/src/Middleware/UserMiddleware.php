<?php


namespace App\Middleware;


use App\Routing\Route;
use App\Service\UserService;

class UserMiddleware implements MiddlewareInterface
{
    private UserService $userService;

    public function __construct(UserService $user_service)
    {
        $this->userService = $user_service;
    }

    public function run(Route $route)
    {
        $controller = $route->getController();

        $user = $this->userService->getCurrentUser();
        $controller->addSharedData("user", $user);
    }
}