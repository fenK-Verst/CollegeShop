<?php


namespace App\Entity\Proxy;

class SiteParamsProxy extends \App\Entity\SiteParams
{
    private bool $__inited = false;
    private \App\Repository\SiteParamsRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\SiteParams $parent;

    /**
     * SiteParamsProxy constructor.
     *
     * @param \App\Repository\SiteParamsRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\SiteParamsRepository $repository, $primaryKeyValue)
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

    public function getVars() : string
    {
        $this->init();
        return $this->parent->getVars();           
    }

    public function setVars(string $vars) : void
    {
        $this->init();
        $this->parent->setVars($vars);           
    }

    public function getParams() : string
    {
        $this->init();
        return $this->parent->getParams();           
    }

    public function setParams(string $params) : void
    {
        $this->init();
        $this->parent->setParams($params);           
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