<?php


namespace App\Controller;


use App\Config;

class ProductController extends AbstractController
{

    /**
     * @Route("/product/1", name="Product.item")
     */
    public function item()
    {
        $product = [];
        return $this->render("product/item.html.twig", [
            "product"=>$product
        ]);
    }

}