<?php


namespace App\Repository;


use App\Db\ObjectDataManager;
use App\Entity\Vendor;

/**
 * Class VendorRepository
 *
 * @package App\Repository
 * @method Vendor find(string $primary_key_value)
 * @method Vendor findOrCreate(string $primary_key_value)
 * @method Vendor[] findAll()
 */
class VendorRepository extends AbstractRepository
{
    public function __construct(ObjectDataManager $dataManager)
    {
        parent::__construct($dataManager, Vendor::class);
    }
}