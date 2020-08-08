<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Image;

/**
 * Class ImageRepository
 *
 * @package App\Repository
 * @method Image find(string $primary_key_value)
 * @method Image findOrCreate(string $primary_key_value)
 * @method Image findBy(array $where, array $order = [], array $limit = []) : array
 * @method Image[] findAll()
 */
class ImageRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Image::class)
    {
        parent::__construct($object_manager, Image::class);
    }
}