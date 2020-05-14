<?php


namespace App\Service;


class CartService
{
    /**
     * @var array
     */
    private $cart;

    public function __construct()
    {
        $this->cart = $_SESSION["cart"] ?? [];
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function addProduct(int $product_id, int $count, int $price)
    {
        $cart_product = $this->cart[$product_id] ?? null;
        if ($cart_product) {
            $this->cart[$product_id]["price"] += $price;
            $this->cart[$product_id]["count"] += $count;

        } else {
            $this->cart[$product_id]["price"] = $price;
            $this->cart[$product_id]["count"] = $count;
        }
        $_SESSION["cart"] = $this->cart;
    }

    public function clearCart()
    {
        unset($_SESSION["cart"]);
        $this->cart = [];
    }

    public function getCount()
    {
        $count = 0;
        foreach ($this->cart as $product){
            $count+=$product["count"];
        }
        return $count;
    }
    public function getPrice()
    {
        $price = 0;
        foreach ($this->cart as $product){
            $price+=$product["price"];
        }
        return $price;
    }

    public function deleteProduct(int $product_id)
    {
        unset($this->cart[$product_id]);
        $_SESSION["cart"] = $this->cart;
    }


}