<?php


namespace App\Routing;


use App\Controller\AbstractController;

class Route
{
    private AbstractController $controller;
    private string $method;
    private array $params = [];

    public function __construct(AbstractController $controller, string $method, array $params)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->params = $params;

        $controller->setRoute($this);
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }
    public function get(string $param)
    {
        return $this->params[$param] ?? null;
    }


}