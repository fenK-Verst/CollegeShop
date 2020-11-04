<?php


namespace App\Controller;


use App\Http\Response;
use App\Routing\Route;
use App\Service\UserService;
use App\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractController
{
    private Twig $twig;
    private array $sharedData = [];
    private Response $response;
    private Route $route;
    private UserService $userService;

    public function __construct(Twig $twig, UserService $userService)
    {
        $this->twig = $twig;
        $this->response = new Response();
        $this->userService = $userService;
    }
    public function setRoute(Route $route)
    {
        $this->route = $route;
    }
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $template_name
     * @param array $params
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
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
            "Content-Type" => "application/json;charset=utf-8"
        ]);
        return $this->response;
    }
    public function getUserService()
    {
        return $this->userService;
    }

}