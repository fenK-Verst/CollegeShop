<?php


namespace App\Controller;


use App\Http\Response;
use App\Service\UserService;
use App\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class AbstractController
{
    private Twig        $twig;
    private array       $sharedData = [];
    private Response    $response;
    private UserService $userService;
    private array       $params = [];

    public function __construct(Twig $twig, UserService $userService)
    {
        $this->twig = $twig;
        $this->response = new Response();
        $this->userService = $userService;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $template_name
     * @param array  $params
     * @param int    $status_code
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template_name, $params = [], int $status_code = 200)
    {
        $body = $this->twig->render($template_name, array_merge_recursive($params, $this->getSharedData()));
        $this->response->setBody($body);
        $this->response->setStatusCode($status_code);
        return $this->response;
    }

    /**
     * @param string $url
     *
     * @return Response
     */
    public function redirect(string $url): Response
    {
        $this->response->redirect($url);
        return $this->response;
    }

    /**
     * @param string $key
     * @param        $value
     */
    public function addSharedData(string $key, $value)
    {
        $this->sharedData["app"][$key] = $value;
    }

    /**
     * @return array
     */
    public function getSharedData(): array
    {
        return $this->sharedData;
    }

    /**
     * @param $json
     *
     * @return Response
     */
    public function json($json)
    {
        $json = json_encode($json);
        $this->response->setBody($json);
        $this->response->setHeaders([
            "Content-Type" => "application/json;charset=utf-8"
        ]);
        return $this->response;
    }

    /**
     * @return UserService
     */
    public function getUserService(): UserService
    {
        return $this->userService;
    }

    public function setSharedData(array $shared_data)
    {
        $this->sharedData = $shared_data;
    }

    public function getParam($key)
    {
        return $this->getParams()[$key] ?? null;
    }


}