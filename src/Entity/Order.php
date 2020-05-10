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
    public const STATUS_WAITING = 1;
    public const STATUS_PAID = 2;
    public const STATUS_DONE = 3;
    public const STATUS_ARCHIVED = 4;
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return DateTime::createFromFormat("Y-m-d H:i:s", $this->created_at);
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
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status)
    {
        if (in_array($status, [
            self::STATUS_WAITING,
            self::STATUS_PAID,
            self::STATUS_DONE,
            self::STATUS_ARCHIVED
        ])) {
            $this->status = $status;
        }
    }
}