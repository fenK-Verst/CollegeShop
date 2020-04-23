<?php


namespace App\Controller;


use App\Db\ObjectManager;
use App\Entity\Folder;
use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\FolderRepository;

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
    public function test(FolderRepository $folder_repository, ObjectManager $object_manager)
    {

        return $this->render("test.html.twig");
    }
}