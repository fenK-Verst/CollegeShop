<?php


namespace App\Controller;


use App\Entity\Folder;

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
    public function test(Folder $folder)
    {
        var_dump($folder->getPrimaryKeyValue());
        return $this->render("test.html.twig");
    }
}