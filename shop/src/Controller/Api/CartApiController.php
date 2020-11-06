<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Http\Request;
use App\Http\Response;
use App\Repository\ProductRepository;
use App\Service\CartService;

/**
 * Class CartApiController
 *
 * @Route("/api/cart")
 * @package App\Controller\Api
 */
class CartApiController extends AbstractController
{
    /**
     * @Route("/add")
     * @param Request           $request
     * @param CartService       $cartService
     * @param ProductRepository $productRepository
     *
     * @return Response
     */
    public function add(Request $request, CartService $cartService, ProductRepository $productRepository)
    {

        $response = [];
        $error = false;
        $err_string = '';

        $product_id = (int)$request->get("product_id");
        $count = (int)$request->get("count");
//        $price = (int)$request->get("price");

        if (!$product_id){
            $error = true;
            $err_string.="Invalid product id\n";
        }
        if (!$count){
            $error = true;
            $err_string.="Invalid count\n";
        }

        if (!$error){
            $product = $productRepository->find($product_id);
            if (!$product){
                $error = true;
                $err_string.="Invalid product id\n";
            }
            $price = $product->getPrice()*$count;
        }
        if (!$error){
            $cartService->addProduct($product_id, $count, $price);

            $response["data"] = [];
            $response["data"]["count"] = $cartService->getCount();
            $response["data"]["price"] = $cartService->getPrice();
        }
        $response["status"] = $error ? "KO" : "OK";
        $response["error_msg"] = $err_string;

        return $this->json($response);
    }

    /**
     * @Route("/clear")
     * @param CartService $cartService
     *
     * @return Response
     */
    public function clear(CartService $cartService)
    {
        $response = [];
        $error = false;
        $err_string = '';

        $cartService->clearCart();

        $response["status"] = $error ? "KO" : "OK";
        $response["error_msg"] = $err_string;

        return $this->json($response);

    }
}