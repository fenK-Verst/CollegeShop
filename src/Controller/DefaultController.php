<?php


namespace App\Controller;


use App\Db\ArrayDataManager;

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
    public function test(ArrayDataManager $array_data_manager)
    {
        $a = $array_data_manager->fetchAllHash("SELECT * FROM test", "id");
        var_dump($a);
        return $this->render("test.html.twig");
    }
}