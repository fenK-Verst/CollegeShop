<?php


namespace App\Entity\Proxy;

class VendorProxy extends \App\Entity\Vendor
{
    private bool $__inited = false;
    private \App\Repository\VendorRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Vendor $parent;

    /**
     * VendorProxy constructor.
     *
     * @param \App\Repository\VendorRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\VendorRepository $repository, $primaryKeyValue)
    {
        $this->repository = $repository;
        $this->primaryKeyValue = $primaryKeyValue;
    }

    private function init()
    {
        if (!$this->__inited) {
            $original = $this->repository->find($this->primaryKeyValue);
            $this->parent = $original;
            $this->__inited = true;
        }
    }
    public function getEntityParams():array
    {
        $this->init();
        return $this->parent->getEntityParams();
    }
    
    public function getId()
    {
        $this->init();
        $this->parent->getId();           
    }

    public function getName()
    {
        $this->init();
        $this->parent->getName();           
    }

    public function setName(string $name) : void
    {
        $this->init();
        $this->parent->setName($name);           
    }

    public function getProducts()
    {
        $this->init();
        $this->parent->getProducts();           
    }

    public function addProduct(?\App\Entity\Product $product)
    {
        $this->init();
        $this->parent->addProduct($product);           
    }

}