<?php


namespace App\Entity\Proxy;

class FolderProxy extends \App\Entity\Folder
{
    private bool $__inited = false;
    private \App\Repository\FolderRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Folder $parent;

    /**
     * FolderProxy constructor.
     *
     * @param \App\Repository\FolderRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\FolderRepository $repository, $primaryKeyValue)
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

    public function getLeft() : int
    {
        $this->init();
        return $this->parent->getLeft();           
    }

    public function setLeft(string $left)
    {
        $this->init();
        $this->parent->setLeft($left);           
    }

    public function getRight() : int
    {
        $this->init();
        return $this->parent->getRight();           
    }

    public function setRight(string $right) : void
    {
        $this->init();
        $this->parent->setRight($right);           
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

    public function getLvl() : int
    {
        $this->init();
        return $this->parent->getLvl();           
    }

    public function setLvl(int $lvl)
    {
        $this->init();
        $this->parent->setLvl($lvl);           
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