<?php


namespace App\Controller;


use App\Http\Request;
use App\Repository\ProductRepository;
use App\Service\CartService;

class CartController extends AbstractController
{
    /**
     * @Route("/cart")
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
     */
    public function clear(CartService $cartService)
    {
        $cartService->clearCart();

        return $this->redirect("/");
    }
    /**
     * @Route("/cart/{id}/delete")
     */
    public function delete(CartService $cartService, Request $request)
    {
        $product_id = (int) $this->getRoute()->get("id");
        $cartService->deleteProduct($product_id);

        return $this->redirect("/cart");
    }

}