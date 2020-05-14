<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\OrderItem;

/**
 * Class OrderItemRepository
 *
 * @package App\Repository
 * @method OrderItem find(string $primary_key_value)
 * @method OrderItem findOrCreate(string $primary_key_value)
 * @method OrderItem findBy(array $where, array $OrderItem = [], array $limit = []) : array
 * @method OrderItem[] findAll()
 */
class OrderItemRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, OrderItem::class);
    }
}