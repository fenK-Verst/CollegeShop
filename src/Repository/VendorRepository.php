<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\Vendor;

/**
 * Class VendorRepository
 *
 * @package App\Repository
 * @method Vendor find(string $primary_key_value)
 * @method Vendor findOrCreate(string $primary_key_value)
 * @method Vendor findBy(array $where, array $order = [], array $limit = []) : array
 * @method Vendor[] findAll()
 */
class VendorRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, Vendor::class);
    }
}