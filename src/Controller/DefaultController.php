<?php


namespace App\Controller;


use App\Db\ObjectManager;
use App\Entity\Folder;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\FolderRepository;

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
    public function index()
    {
        return $this->render("title.html.twig");
    }


}