<?php


namespace App\Controller;


use App\Http\Request;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;

/**
 * Class ProductController
 *
 * @Route("/folder")
 * @package App\Controller
 */
class FolderController extends AbstractController
{
    /**
     * @Route("/{id}", name="index")
     */
    public function index(FolderRepository $folder_repository)
    {
        $folder_id = $this->getRoute()->get("id");
        $folder = $folder_repository->find($folder_id);
        $products = $folder->getProducts();
        $folders = $folder_repository->getSubFolders($folder);
        return $this->render("product/list.html.twig", [
            "products" => $products,
            "folders"=>$folders
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