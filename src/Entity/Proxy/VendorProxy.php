<?php


namespace App\Entity\Proxy;


use App\Entity\Product;
use App\Entity\Vendor;
use App\Repository\VendorRepository;

class VendorProxy extends Vendor
{
    private bool $__inited = false;
    private VendorRepository $repository;
    private $primaryKey;
    /**
     * @var Vendor
     */
    private Vendor $parent;

    /**
     * VendorProxy constructor.
     *
     * @param VendorRepository $repository
     * @param $primaryKey
     */
    public function __construct(VendorRepository $repository, $primaryKey)
    {
        $this->repository = $repository;
        $this->primaryKey = $primaryKey;
    }

    private function init()
    {
        if (!$this->__inited){
            $original = $this->repository->find($this->primaryKey);
            $this->parent = $original;
            $this->__inited = true;
        }
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

    /**
     **
     * @return array
     */
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
}