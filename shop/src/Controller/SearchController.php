<?php


namespace App\Controller;

use App\Http\Request;
use App\Repository\ProductRepository;

/**
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/search")
     */
    public function index(Request $request, ProductRepository $product_repository)
    {
        $product_name = $request->get("name");
        $products = $product_repository->getByName($product_name);
        return $this->render("product/list.html.twig", [
            "products"=>$products
        ]);
    }
}