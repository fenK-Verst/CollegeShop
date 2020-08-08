<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Order;

/**
 * Class OrderRepository
 *
 * @package App\Repository
 * @method Order find(string $primary_key_value)
 * @method Order findOrCreate(string $primary_key_value)
 * @method Order findBy(array $where, array $order = [], array $limit = []) : array
 * @method Order[] findAll()
 */
class OrderRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Order::class)
    {
        parent::__construct($object_manager, Order::class);
    }
}