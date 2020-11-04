<?php


namespace App\Entity\Proxy;

class OrderProxy extends \App\Entity\Order
{
    private bool $__inited = false;
    private \App\Repository\OrderRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Order $parent;

    /**
     * OrderProxy constructor.
     *
     * @param \App\Repository\OrderRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\OrderRepository $repository, $primaryKeyValue)
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

    public function getCreatedAt() : string
    {
        $this->init();
        return $this->parent->getCreatedAt();           
    }

    public function setCreatedAt(?\DateTime $date_time) : void
    {
        $this->init();
        $this->parent->setCreatedAt($date_time);           
    }

    public function getStatus() : string
    {
        $this->init();
        return $this->parent->getStatus();           
    }

    public function setStatus(string $status)
    {
        $this->init();
        $this->parent->setStatus($status);           
    }

    public function getOrderItems() : array
    {
        $this->init();
        return $this->parent->getOrderItems();           
    }

    public function addOrderItem(?\App\Entity\OrderItem $item)
    {
        $this->init();
        $this->parent->addOrderItem($item);           
    }

    public function getStat() : array
    {
        $this->init();
        return $this->parent->getStat();           
    }

    public function setUser(?\App\Entity\User $user) : void
    {
        $this->init();
        $this->parent->setUser($user);           
    }

    public function getUser() : ?\App\Entity\User
    {
        $this->init();
        return $this->parent->getUser();           
    }

    public function getStatuses()
    {
        $this->init();
        $this->parent->getStatuses();           
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