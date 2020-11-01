<?php


namespace App\Entity\Proxy;

class MenuProxy extends \App\Entity\Menu
{
    private bool $__inited = false;
    private \App\Repository\MenuRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Menu $parent;

    /**
     * MenuProxy constructor.
     *
     * @param \App\Repository\MenuRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\MenuRepository $repository, $primaryKeyValue)
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

    public function getRoutes() : array
    {
        $this->init();
        return $this->parent->getRoutes();           
    }

    public function addRoute(?\App\Entity\CustomRoute $route)
    {
        $this->init();
        $this->parent->addRoute($route);           
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