<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\Product;

/**
 * Class ProductRepository
 *
 * @package App\Repository
 * @method Product find(string $primary_key_value)
 * @method Product findOrCreate(string $primary_key_value)
 * @method Product findBy(array $where, array $order = [], array $limit = []) : array
 * @method Product[] findAll()
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, Product::class);
    }
}