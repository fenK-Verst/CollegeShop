<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\EntityInterface;

/**
 * Interface RepositoryInterface
 * @package App\Repository
 */
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

    /**
     * @param array $where
     * @param array $order
     * @return EntityInterface|null
     */
    public function findOneBy(array $where, array $order): ?EntityInterface;

    /**
     * @param string $primary_key
     * @return EntityInterface
     */
    public function findOrCreate(string $primary_key): EntityInterface;

    /**
     * @param string $primary_key
     * @return EntityInterface|null
     */
    public function find(string $primary_key): ?EntityInterface;


}