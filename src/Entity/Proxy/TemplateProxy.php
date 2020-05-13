<?php


namespace App\Entity\Proxy;

class TemplateProxy extends \App\Entity\Template
{
    private bool $__inited = false;
    private \App\Repository\TemplateRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Template $parent;

    /**
     * TemplateProxy constructor.
     *
     * @param \App\Repository\TemplateRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\TemplateRepository $repository, $primaryKeyValue)
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
    
    public function getVars()
    {
        $this->init();
        $this->parent->getVars();           
    }

    public function setVars(array $vars) : void
    {
        $this->init();
        $this->parent->setVars($vars);           
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