<?php


namespace App;


use App\Http\Response;
use App\Routing\Route;

interface KernelInterface
{
    public function run();

    public function dispatch(Route $route): Response;
}