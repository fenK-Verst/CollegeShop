<?php


namespace App\Entity;

use DateTime;

/**
 * Class Order
 * @Entity(tableName="order_item", repositoryClass="App\Repository\OrderItemRepository")
 *
 * @package App\Entity
 */
class OrderItem extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $count;

    /**
     * @Entity\ManyToOne(entity="App\Entity\Order", primary_key="order_id")
     */
    protected $order;

    /**
     * @return int
     */
    public function getId() :?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCount() :?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return Order|null
     */
    public function getOrder() :?Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }
}