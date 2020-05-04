<?php


namespace App\Controller;


use App\Db\ObjectManager;
use App\Entity\Folder;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\FolderRepository;
use App\Repository\ProductRepository;

/**
 * Class DefaultController
 *
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ProductRepository $product_repository)
    {
        $news = $product_repository->getWithFlags([2]);
        return $this->render("title.html.twig",[
            "news"=>$news
        ]);
    }


}