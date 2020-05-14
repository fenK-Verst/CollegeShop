<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\ProductParam;
use App\Entity\ProductParamValue;
use App\Entity\Vendor;

/**
 * Class ProductParamValueRepository
 *
 * @package App\Repository
 * @method ProductParamValue find(string $primary_key_value)
 * @method ProductParamValue findOrCreate(string $primary_key_value)
 * @method ProductParamValue findBy(array $where, array $order = [], array $limit = []) : array
 * @method ProductParamValue[] findAll()
 */
class ProductParamValueRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, ProductParamValue::class);
    }
}