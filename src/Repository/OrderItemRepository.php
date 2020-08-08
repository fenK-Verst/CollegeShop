<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
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
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = OrderItem::class)
    {
        parent::__construct($object_manager, OrderItem::class);
    }
}