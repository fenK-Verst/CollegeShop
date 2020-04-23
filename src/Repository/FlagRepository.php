<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\Flag;

/**
 * Class FlagRepository
 *
 * @package App\Repository
 * @method Flag find(string $primary_key_value)
 * @method Flag findOrCreate(string $primary_key_value)
 * @method Flag findBy(array $where, array $order = [], array $limit = []) : array
 * @method Flag[] findAll()
 */
class FlagRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, Flag::class);
    }
}