<?php


namespace App\Controller;


use App\Http\Request;
use App\Http\Response;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CartController extends AbstractController
{
    /**
     * @Route("/cart")
     * @param CartService       $cartService
     * @param ProductRepository $productRepository
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function cart(CartService $cartService, ProductRepository $productRepository)
    {
        $cart = $cartService->getCart();
        $products = [];
        foreach ($cart as $id=>$product)
        {
            $products[] = $productRepository->find($id);
        }

        return $this->render("cart/cart.html.twig", [
            "cart"=>$cart,
            "products"=>$products
        ]);
    }

    /**
     * @Route("/cart/clear")
     * @param CartService $cartService
     *
     * @return Response
     */
    public function clear(CartService $cartService)
    {
        $cartService->clearCart();

        return $this->redirect("/cart");
    }

    /**
     * @Route("/cart/{id}/delete")
     * @param CartService $cartService
     *
     * @return Response
     */
    public function delete(CartService $cartService)
    {
        $product_id = (int) $this->getParam("id");
        $cartService->deleteProduct($product_id);

        return $this->redirect("/cart");
    }

}