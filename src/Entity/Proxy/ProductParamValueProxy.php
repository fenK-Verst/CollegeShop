<?php


namespace App\Entity\Proxy;

class ProductParamValueProxy extends \App\Entity\ProductParamValue
{
    private bool $__inited = false;
    private \App\Repository\ProductParamValueRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\ProductParamValue $parent;

    /**
     * ProductParamValueProxy constructor.
     *
     * @param \App\Repository\ProductParamValueRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\ProductParamValueRepository $repository, $primaryKeyValue)
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
    
    public function getProductParam() : array
    {
        $this->init();
        return $this->parent->getProductParam();           
    }

    public function setProductParam(?\App\Entity\ProductParam $productParam)
    {
        $this->init();
        $this->parent->setProductParam($productParam);           
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

    public function getValue() : string
    {
        $this->init();
        return $this->parent->getValue();           
    }

    public function setValue(string $value) : void
    {
        $this->init();
        $this->parent->setValue($value);           
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