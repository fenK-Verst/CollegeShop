<?php


namespace App\Entity\Proxy;

class StonkProxy extends \App\Entity\Stonk
{
    private bool $__inited = false;
    private \App\Repository\StonkRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Stonk $parent;

    /**
     * StonkProxy constructor.
     *
     * @param \App\Repository\StonkRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\StonkRepository $repository, $primaryKeyValue)
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

    public function getTitle() : string
    {
        $this->init();
        return $this->parent->getTitle();           
    }

    public function setTitle(string $title) : void
    {
        $this->init();
        $this->parent->setTitle($title);           
    }

    public function getDescription() : string
    {
        $this->init();
        return $this->parent->getDescription();           
    }

    public function setDescription(string $description) : void
    {
        $this->init();
        $this->parent->setDescription($description);           
    }

    public function getSumm() : float
    {
        $this->init();
        return $this->parent->getSumm();           
    }

    public function setSumm(float $summ) : void
    {
        $this->init();
        $this->parent->setSumm($summ);           
    }

    public function getCreatedAt() : string
    {
        $this->init();
        return $this->parent->getCreatedAt();           
    }

    public function setCreatedAt(string $created_at) : void
    {
        $this->init();
        $this->parent->setCreatedAt($created_at);           
    }

    public function getUser() : ?\App\Entity\User
    {
        $this->init();
        return $this->parent->getUser();           
    }

    public function setUser(?\App\Entity\User $user) : void
    {
        $this->init();
        $this->parent->setUser($user);           
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