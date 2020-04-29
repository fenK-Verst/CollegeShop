<?php


namespace App\Entity\Proxy;

class ImageProxy extends \App\Entity\Image
{
    private bool $__inited = false;
    private \App\Repository\ImageRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Image $parent;

    /**
     * ImageProxy constructor.
     *
     * @param \App\Repository\ImageRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\ImageRepository $repository, $primaryKeyValue)
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

    public function getPath() : string
    {
        $this->init();
        return $this->parent->getPath();           
    }

    public function setPath(string $path) : void
    {
        $this->init();
        $this->parent->setPath($path);           
    }

    public function getAlias() : string
    {
        $this->init();
        return $this->parent->getAlias();           
    }

    public function setAlias(string $alias) : void
    {
        $this->init();
        $this->parent->setAlias($alias);           
    }

}