<?php


namespace App\Middleware;


use App\Routing\Route;
use App\Service\CartService;
use App\Service\UserService;

class CartMiddleware implements MiddlewareInterface
{
    private CartService $cartService;

    public function __construct(CartService $cart_service)
    {
        $this->cartService = $cart_service;
    }

    public function run(Route $route)
    {


        $cart_service = $this->cartService;
        $route->addSharedData("cartService", $cart_service);
    }
}