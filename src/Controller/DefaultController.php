<?php


namespace App\Controller;


use App\Entity\Folder;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;

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
    public function test(FolderRepository $folder_repository, ProductRepository $product_repository, VendorRepository $vendor_repository)
    {
        $folder = $folder_repository->find(1);
        $product = $product_repository->find(1);
        $vendor = $vendor_repository->find(1);
        return $this->render("test.html.twig");
    }
}