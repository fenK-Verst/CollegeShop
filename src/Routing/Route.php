<?php


namespace App\Routing;


use App\Controller\AbstractController;

class Route
{
    private AbstractController $controller;
    private string $method;

    public function __construct(AbstractController $controller, string $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }
    public function getController()
    {
        return $this->controller;
    }
    public function getMethod()
    {
        return $this->method;
    }


}