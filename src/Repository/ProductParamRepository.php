<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\ProductParam;

/**
 * Class ProductParamRepository
 *
 * @package App\Repository
 * @method ProductParam find(string $primary_key_value)
 * @method ProductParam findOrCreate(string $primary_key_value)
 * @method ProductParam findBy(array $where, array $order = [], array $limit = []) : array
 * @method ProductParam findOneBy(array $where, array $order = []) : array
 * @method ProductParam[] findAll()
 */
class ProductParamRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = ProductParam::class)
    {
        parent::__construct($object_manager, ProductParam::class);
    }
}