<?php


namespace App\Controller;


class FolderController extends AbstractController
{
    /**
     * @Route("/folder", name="Folder")
     */
    public function index()
    {

        return $this->render("base.html.twig");
    }
}