<?php


namespace App\Entity\Proxy;


use App\Entity\Product;

class FlagProxy extends \App\Entity\Flag
{
    private bool $__inited = false;

    public function __construct()
    {

    }

    private function init()
    {
        $this->__inited = true;
    }
    public function getProducts(): array
    {
        if (!$this->__inited) $this->init();
        return parent::getProducts();
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        if (!$this->__inited) $this->init();
        parent::addProduct($product);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        if (!$this->__inited) $this->init();
        return parent::getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        if (!$this->__inited) $this->init();
        return parent::getName();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        if (!$this->__inited) $this->init();
         parent::setName($name);
    }
}