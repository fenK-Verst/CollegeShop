<?php


namespace App\Middleware;


use App\Routing\Route;

interface MiddlewareInterface
{
    public function run(Route $route);
}