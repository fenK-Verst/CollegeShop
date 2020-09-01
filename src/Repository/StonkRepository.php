<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Stonk;

/**
 * Class StonkRepository
 *
 * @package App\Repository
 * @method Stonk find(string $primary_key_value)
 * @method Stonk findOrCreate(string $primary_key_value)
 * @method Stonk findBy(array $where, array $order = [], array $limit = []) : array
 * @method Stonk findOneBy(array $where, array $order = []) : array
 * @method Stonk[] findAll()
 */
class StonkRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Stonk::class)
    {
        parent::__construct($object_manager, Stonk::class);
    }
}