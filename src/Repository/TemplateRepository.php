<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Template;

/**
 * Class TemplateRepository
 *
 * @package App\Repository
 * @method Template find(string $primary_key_value)
 * @method Template findOrCreate(string $primary_key_value)
 * @method Template findBy(array $where, array $order = [], array $limit = []) : array
 * @method Template[] findAll()
 */
class TemplateRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Template::class)
    {
        parent::__construct($object_manager, Template::class);
    }
}