<?php


namespace App\Controller;


use App\Http\Response;
use App\Twig;

abstract class AbstractController
{
    private $twig;
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $template_name, $params = [])
    {
            $body = $this->twig->render($template_name, $params);

            return new Response($body);
    }
}