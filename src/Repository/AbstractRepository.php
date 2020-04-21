<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Entity\EntityInterface;

class AbstractRepository implements RepositoryInterface
{

    public function __construct(ObjectDataManagerInterface $object_data_manager)
    {
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function findBy(array $where, array $order, array $limit): array
    {
        // TODO: Implement findBy() method.
    }

    public function remove(EntityInterface $entity): bool
    {
        // TODO: Implement remove() method.
    }

    public function getObjectDataManager(): ObjectDataManagerInterface
    {
        // TODO: Implement getObjectDataManager() method.
    }
}