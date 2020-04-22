<?php


namespace App\Entity\Proxy;


use App\Entity\Product;
use App\Repository\FlagRepository;

class FlagProxy extends \App\Entity\Flag
{
    private bool $__inited = false;
    private FlagRepository $repository;
    private $primaryKey;
    private \App\Entity\Flag $parent;

    /**
     * FlagProxy constructor.
     *
     * @param FlagRepository $repository
     * @param $primaryKey
     */
    public function __construct(FlagRepository $repository, $primaryKey)
    {
        $this->repository = $repository;
        $this->primaryKey = $primaryKey;
    }

    private function init()
    {
        if (!$this->__inited) {
            $original = $this->repository->find($this->primaryKey);
            $this->parent = $original;
            $this->__inited = true;
        }
    }
    public function getProducts(): array
    {
        $this->init();
        return $this->parent->getProducts();
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->init();
        $this->parent->addProduct($product);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        $this->init();
        return $this->parent->getId();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $this->init();
        return $this->parent->getName();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->init();
        $this->parent->setName($name);
    }
}