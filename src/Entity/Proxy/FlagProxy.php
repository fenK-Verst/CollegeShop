<?php


namespace App\Entity\Proxy;

class FlagProxy extends \App\Entity\Flag
{
    private bool $__inited = false;
    private \App\Repository\FlagRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Flag $parent;

    /**
     * FlagProxy constructor.
     *
     * @param \App\Repository\FlagRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\FlagRepository $repository, $primaryKeyValue)
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

}