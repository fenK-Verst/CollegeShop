<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\CustomRoute;

/**
 * Class CustomRouteRepository
 *
 * @package App\Repository
 * @method CustomRoute find(string $primary_key_value)
 * @method CustomRoute findOrCreate(string $primary_key_value)
 * @method CustomRoute findBy(array $where, array $order = [], array $limit = []) : array
 * @method CustomRoute[] findAll()
 */
class CustomRouteRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, CustomRoute::class);
    }
}