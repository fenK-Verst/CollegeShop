<?php


namespace App\Controller;


use App\Http\Response;
use App\Twig;

abstract class AbstractController
{
    private Twig $twig;
    private array $sharedData = [];

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $template_name, $params = [])
    {
        $body = $this->twig->render($template_name, array_merge_recursive($params, $this->getSharedData()));
        return new Response($body);
    }

    public function addSharedData(string $key, $value)
    {
        $this->sharedData[$key] = $value;
    }

    public function getSharedData()
    {
        return $this->sharedData;
    }
}