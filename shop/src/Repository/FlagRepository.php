<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Flag;

/**
 * Class FlagRepository
 *
 * @package App\Repository
 * @method Flag find(string $primary_key_value)
 * @method Flag findOrCreate(string $primary_key_value)
 * @method Flag findBy(array $where, array $order = [], array $limit = []) : array
 * @method Flag findOneBy(array $where, array $order = []) : array
 * @method Flag[] findAll()
 */
class FlagRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Flag::class)
    {
        parent::__construct($object_manager, Flag::class);
    }
}