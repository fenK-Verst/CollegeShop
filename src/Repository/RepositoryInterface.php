<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\EntityInterface;

interface RepositoryInterface
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class);

    public function findAll(): array;

    public function findBy(array $where, array $order, array $limit): array;

    public function findOrCreate(string $primary_key):EntityInterface;

    public function find(string $primary_key):?EntityInterface;


}