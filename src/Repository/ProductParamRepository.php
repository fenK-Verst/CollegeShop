<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\ProductParam;
use App\Entity\Vendor;

/**
 * Class ProductParamRepository
 *
 * @package App\Repository
 * @method ProductParam find(string $primary_key_value)
 * @method ProductParam findOrCreate(string $primary_key_value)
 * @method ProductParam findBy(array $where, array $order = [], array $limit = []) : array
 * @method ProductParam[] findAll()
 */
class ProductParamRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, ProductParam::class);
    }
}