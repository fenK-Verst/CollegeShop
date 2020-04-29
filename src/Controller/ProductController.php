<?php


namespace App\Controller;


use App\Http\Request;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;

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
            "product" => $product
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function list(Request $request, ProductRepository $product_repository, VendorRepository $vendor_repository)
    {
        $filter = $request->get("filter") ?? [];
        $vendors = $vendor_repository->findAll();
        $limit = [0 => 10];
        $products = $product_repository->getFiltered($filter, $limit);
        return $this->render("product/list.html.twig", [
            "products" => $products,
            "vendors" => $vendors,
            "filter" => $filter
        ]);
    }


}