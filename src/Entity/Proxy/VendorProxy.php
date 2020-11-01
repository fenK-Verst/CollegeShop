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
     * @param $primaryKeyValue
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
//    public function getEntityParams():array
//    {
//        $this->init();
//        return $this->parent->getEntityParams();
//    }
    
    public function getId() : int
    {
        $this->init();
        return $this->parent->getId();           
    }

    public function getName() : string
    {
        $this->init();
        return $this->parent->getName();           
    }

    public function setName(string $name) : void
    {
        $this->init();
        $this->parent->setName($name);           
    }

    public function getProducts() : array
    {
        $this->init();
        return $this->parent->getProducts();           
    }

    public function addProduct(?\App\Entity\Product $product)
    {
        $this->init();
        $this->parent->addProduct($product);           
    }

    public function getTableName() : string
    {
        $this->init();
        return $this->parent->getTableName();           
    }

    public function getRepositoryClass() : string
    {
        $this->init();
        return $this->parent->getRepositoryClass();           
    }

    public function getPrimaryKey() : string
    {
        $this->init();
        return $this->parent->getPrimaryKey();           
    }

    public function getColumns() : array
    {
        $this->init();
        return $this->parent->getColumns();           
    }

    public function getEntityParams() : array
    {
        $this->init();
        return $this->parent->getEntityParams();           
    }

    public function getPrimaryKeyValue() : string
    {
        $this->init();
        return $this->parent->getPrimaryKeyValue();           
    }

    public function getColumnValue(string $column) : string
    {
        $this->init();
        return $this->parent->getColumnValue($column);           
    }

    public function getSingleDependencies() : array
    {
        $this->init();
        return $this->parent->getSingleDependencies();           
    }

}