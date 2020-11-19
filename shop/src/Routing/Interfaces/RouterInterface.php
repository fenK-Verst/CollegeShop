<?php


namespace App\Routing\Interfaces;


use App\Routing\Route;

interface RouterInterface
{
    public function dispatch(): Route;

    public function getErrorRoute(int $status_code): Route;
}