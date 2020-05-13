<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\Menu;

/**
 * Class MenuRepository
 *
 * @package App\Repository
 * @method Menu find(string $primary_key_value)
 * @method Menu findOrCreate(string $primary_key_value)
 * @method Menu findBy(array $where, array $order = [], array $limit = []) : array
 * @method Menu[] findAll()
 */
class MenuRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, Menu::class);
    }
}