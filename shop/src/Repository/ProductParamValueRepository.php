<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
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
 * @method ProductParamValue findOneBy(array $where, array $order = []) : array
 * @method ProductParamValue[] findAll()
 */
class ProductParamValueRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class=ProductParamValue::class)
    {
        parent::__construct($object_manager, ProductParamValue::class);
    }
}