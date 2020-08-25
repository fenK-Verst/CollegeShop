<?php


namespace App\Controller;


use App\Repository\ProductRepository;
use App\Routing\Route;

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
        $news = $product_repository->getWithFlags([2], [8]);
        return $this->render("title.html.twig",[
            "news"=>$news
        ]);
    }
    /**
     * @Route("/sessions")
     *
     */
    public function f()
    {
        $_SESSION["cart"] = [];
        $_SESSION["cart"][1] = array
        (
            "price" => 37044,
            "count" => 2
        );

        $_SESSION["cart"][2] = array
        (
            "price" => 11508,
            "count" => 2
        );

        $_SESSION["cart"][3] = array
        (
            "price" => 37716,
            "count" => 2
        );

        $_SESSION["cart"][4] = array
        (
            "price" => 20796,
            "count" => 2
        );

        $_SESSION["cart"][8] = array
        (
            "price" => 25028,
            "count" => 2
        );

        $_SESSION["cart"][7] = array
        (
            "price" => 20734,
            "count" => 2
        );

        $_SESSION["cart"][6] = array
        (
            "price" => 18980,
            "count" => 2
        );

        $_SESSION["cart"][5] = array
        (
            "price" => 18468,
            "count" => 2
        );

        $_SESSION["cart"][9] = array
        (
            "price" => 39826,
            "count" => 2
        );

        $_SESSION["cart"][10] = array
        (
            "price" => 19942,
            "count" => 2
        );

        $_SESSION["cart"][11] = array
        (
            "price" => 6296,
            "count" => 1
        );

        $_SESSION["cart"][15] = array
        (
            "price" => 13145,
            "count" => 1
        );

        $_SESSION["cart"][16] = array
        (
            "price" => 7435,
            "count" => 1
        );

        $_SESSION["cart"][12] = array
        (
            "price" => 14811,
            "count" => 1
        );

        $_SESSION["cart"][13] = array
        (
            "price" => 17337,
            "count" => 1
        );

        $_SESSION["cart"][17] = array
        (
            "price" => 15873,
            "count" => 1
        );

        $_SESSION["cart"][18] = array
        (
            "price" => 12571,
            "count" => 1
        );

        $_SESSION["cart"][14] = array
        (
            "price" => 13769,
            "count" => 1
        );

        $_SESSION["cart"][20] = array
        (
            "price" => 14736,
            "count" => 1
        );

        $_SESSION["cart"][25] = array
        (
            "price" => 13680,
            "count" => 1
        );
        $_SESSION["cart"][24] = array
        (
            "price" => 12571,
            "count" => 1
        );

        $_SESSION["cart"][23] = array
        (
            "price" => 13769,
            "count" => 1
        );

        $_SESSION["cart"][21] = array
        (
            "price" => 14736,
            "count" => 1
        );

        $_SESSION["cart"][25] = array
        (
            "price" => 13680,
            "count" => 1
        );
        $_SESSION["cart"][26] = array
        (
            "price" => 13680,
            "count" => 1
        );
        $_SESSION["cart"][27] = array
        (
            "price" => 12571,
            "count" => 1
        );

        $_SESSION["cart"][28] = array
        (
            "price" => 13769,
            "count" => 1
        );

        $_SESSION["cart"][29] = array
        (
            "price" => 14736,
            "count" => 1
        );

        $_SESSION["cart"][30] = array
        (
            "price" => 13680,
            "count" => 1
        );
        return $this->redirect("/cart");
    }

    /**
     * @Route("/appletree")
     */
    public function apple()
    {
        return $this->render("apple/apple.html.twig");
    }

}