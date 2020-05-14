<?php


namespace App\Controller;


use App\Http\Response;
use App\Routing\Route;
use App\Twig;

abstract class AbstractController
{
    private Twig $twig;
    private array $sharedData = [];
    private Response $response;
    private Route $route;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
        $this->response = new Response();
    }
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }
    public function getRoute()
    {
        return $this->route;
    }
    public function render(string $template_name, $params = [])
    {
        $body = $this->twig->render($template_name, array_merge_recursive($params, $this->getSharedData()));
        $this->response->setBody($body);
        return $this->response;
    }
    public function redirect(string $url)
    {
        $this->response->redirect($url);
        return $this->response;
    }
    public function addSharedData(string $key, $value)
    {
        $this->sharedData["app"][$key] = $value;
    }

    public function getSharedData()
    {
        return $this->sharedData;
    }
    public function json($json)
    {
        $json = json_encode($json);
        $this->response->setBody($json);
        $this->response->setHeaders([
            "Content-Type"=>"application/json;charset=utf-8"
        ]);
        return $this->response;
    }
}