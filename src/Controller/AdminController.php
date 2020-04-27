<?php


namespace App\Controller;

use App\Repository\VendorRepository;

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