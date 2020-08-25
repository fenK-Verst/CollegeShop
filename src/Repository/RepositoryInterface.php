<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\EntityInterface;

interface RepositoryInterface
{
    /**
     * RepositoryInterface constructor.
     * @param ObjectManagerInterface $object_manager
     * @param string $entity_class
     */
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class);

    /**
     * @return EntityInterface[]
     */
    public function findAll(): array;

    /**
     * @param array $where
     * @param array $order
     * @param array $limit
     * @return EntityInterface[]
     */
    public function findBy(array $where, array $order, array $limit): array;

    public function findOrCreate(string $primary_key):EntityInterface;

    public function find(string $primary_key):?EntityInterface;


}