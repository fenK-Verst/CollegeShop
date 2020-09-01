<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Vendor;

/**
 * Class VendorRepository
 *
 * @package App\Repository
 * @method Vendor find(string $primary_key_value)
 * @method Vendor findOrCreate(string $primary_key_value)
 * @method Vendor findBy(array $where, array $order = [], array $limit = []) : array
 * @method Vendor findOneBy(array $where, array $order = []) : array
 * @method Vendor[] findAll()
 */
class VendorRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Vendor::class)
    {
        parent::__construct($object_manager, Vendor::class);
    }
}