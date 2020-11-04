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
    public function list(FolderRepository $folder_repository)
    {
        $folders = $folder_repository->findAll();
        return $this->render("folder/list.html.twig", [
            "folders"=>$folders
        ]);
    }

    


}