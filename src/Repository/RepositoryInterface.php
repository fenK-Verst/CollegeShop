<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Entity\EntityInterface;

interface RepositoryInterface
{
    public function __construct(ObjectDataManagerInterface $object_data_manager, string $entity_class);

    public function findAll(): array;

    public function findBy(array $where, array $order, array $limit): array;

    public function remove(EntityInterface $entity): bool;

    public function getObjectDataManager(): ObjectDataManagerInterface;

    public function findOrCreate(string $primary_key):EntityInterface;

    public function find(string $primary_key):?EntityInterface;

    public function save(EntityInterface $entity);

}