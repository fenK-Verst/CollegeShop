<?php


namespace App\Entity\Proxy;

class OrderItemProxy extends \App\Entity\OrderItem
{
    private bool $__inited = false;
    private \App\Repository\OrderItemRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\OrderItem $parent;

    /**
     * OrderItemProxy constructor.
     *
     * @param \App\Repository\OrderItemRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\OrderItemRepository $repository, $primaryKeyValue)
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

    public function getCount() : int
    {
        $this->init();
        return $this->parent->getCount();           
    }

    public function setCount(int $count) : void
    {
        $this->init();
        $this->parent->setCount($count);           
    }

    public function getOrder() : ?\App\Entity\Order
    {
        $this->init();
        return $this->parent->getOrder();           
    }

    public function setOrder(?\App\Entity\Order $order)
    {
        $this->init();
        $this->parent->setOrder($order);           
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