<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\ProductComment;

/**
 * Class ProductCommentRepository
 *
 * @package App\Repository
 * @method ProductComment find(string $primary_key_value)
 * @method ProductComment findOrCreate(string $primary_key_value)
 * @method ProductComment findBy(array $where, array $order = [], array $limit = []) : array
 * @method ProductComment[] findAll()
 */
class ProductCommentRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, ProductComment::class);
    }
}