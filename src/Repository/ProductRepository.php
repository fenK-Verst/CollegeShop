<?php


namespace App\Repository;


use App\Db\ObjectDataManager;
use App\Entity\Product;

/**
 * Class ProductRepository
 *
 * @package App\Repository
 * @method Product find(string $primary_key_value)
 * @method Product findOrCreate(string $primary_key_value)
 * @method Product[] findAll()
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(ObjectDataManager $dataManager)
    {
        parent::__construct($dataManager, Product::class);
    }
}