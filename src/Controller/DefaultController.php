<?php


namespace App\Controller;


use App\Entity\Folder;
use App\Entity\Product;
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
          $vendor = $vendor_repository->findOrCreate(1);
          $vendor_repository->remove($vendor);
        return $this->render("test.html.twig");
    }
}