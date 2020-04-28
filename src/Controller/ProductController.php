<?php


namespace App\Controller;


use App\Db\ObjectManager;
use App\Entity\Folder;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;

/**
 * Class ProductController
 *
 * @Route("/product")
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/{id}", name="index")
     */
    public function index(ProductRepository $product_repository)
    {
        $product_id = $this->getRoute()->get("id");
        $product = $product_repository->find($product_id);
        return $this->render("product/item.html.twig", [
            "product"=>$product
        ]);
    }


}