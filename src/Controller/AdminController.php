<?php


namespace App\Controller;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render("/admin/index.html.twig", []);
    }
}