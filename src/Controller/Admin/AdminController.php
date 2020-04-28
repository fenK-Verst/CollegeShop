<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
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