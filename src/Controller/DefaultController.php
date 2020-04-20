<?php


namespace App\Controller;


use App\Config;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render("title.html.twig");
    }
    /**
     * @Route("/test", name="text")
     */
    public function test(Config $config)
    {
        $config->getConfig();
        return $this->render("test.html.twig");
    }
}