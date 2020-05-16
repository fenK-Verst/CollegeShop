<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\SiteParams;

/**
 * Class SiteParamsRepository
 *
 * @package App\Repository
 * @method SiteParams find(string $primary_key_value)
 * @method SiteParams findOrCreate(string $primary_key_value)
 * @method SiteParams findBy(array $where, array $order = [], array $limit = []) : array
 * @method SiteParams[] findAll()
 */
class SiteParamsRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, SiteParams::class);
    }
}