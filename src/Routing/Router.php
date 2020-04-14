<?php

namespace App\Routing;
class Router
{
    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }
}