<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\SiteParams;

/**
 * Class SiteParamsRepository
 *
 * @package App\Repository
 * @method SiteParams find(string $primary_key_value)
 * @method SiteParams findOrCreate(string $primary_key_value)
 * @method SiteParams findBy(array $where, array $order = [], array $limit = []) : array
 * @method SiteParams findOneBy(array $where, array $order = []) : array
 * @method SiteParams[] findAll()
 */
class SiteParamsRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = SiteParams::class)
    {
        parent::__construct($object_manager, SiteParams::class);
    }
}