<?php


namespace App\Db\Interfaces;


use App\Entity\EntityInterface;

interface ObjectManagerInterface
{
    public function __construct(ObjectDataManagerInterface $object_data_manager);

    public function save(EntityInterface $entity): EntityInterface;

    public function remove(EntityInterface $entity): bool;

    public function addDependenciesToEntity(EntityInterface $entity): EntityInterface;

    public function getObjectDataManager(): ObjectDataManagerInterface;
}