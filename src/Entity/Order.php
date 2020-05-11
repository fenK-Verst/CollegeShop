<?php


namespace App\Entity;

use DateTime;

/**
 * Class Order
 * @Entity(tableName="order", repositoryClass="App\Repository\OrderRepository")
 *
 * @package App\Entity
 */
class Order extends AbstractEntity
{
    public const STATUS_WAITING = "waiting";
    public const STATUS_PAID = "paid";
    public const STATUS_DONE = "done";
    public const STATUS_ARCHIVED = "archived";


    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $created_at;

    /**
     * @Entity\Column()
     */
    protected $status;

    /**
     * @Entity\ManyToOne(entity="App\Entity\User", primary_key="user_id")
     */
    protected $user;

    /**
     * @Entity\OneToMany(entity="App\Entity\OrderItem", primary_key="order_id")
     */
    protected $order_items = [];


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $date_time
     */
    public function setCreatedAt(DateTime $date_time): void
    {
        $this->created_at = $date_time->format("Y-m-d H:i:s");
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?string
    {
        return (string)$this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        if (in_array($status, array_keys($this::getStatuses()))) {
            $this->status = $status;
        }
    }

    /**
     * @return array
     */
    public function getOrderItems(): array
    {
        return $this->order_items;
    }

    /**
     * @param OrderItem $item
     */
    public function addOrderItem(OrderItem $item)
    {
        if (!in_array($item, (array)$this->order_items)) {
            $this->order_items[] = $item;
        }
    }

    public function getStat(): array
    {
        $sum = 0;
        $count = 0;
        $items = $this->getOrderItems();
        foreach ($items as $item) {
            /**
             * @var OrderItem $item
             */
            $sum += (int)$item->getProduct()->getPrice() * (int)$item->getCount();
            $count += $item->getCount();
        }
        return [
            "sum" => $sum,
            "count" => $count
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_WAITING => "Ожидание оплаты",
            self::STATUS_PAID => "Оплачено",
            self::STATUS_DONE => "Готово",
            self::STATUS_ARCHIVED => "В архиве"
        ];
    }
}