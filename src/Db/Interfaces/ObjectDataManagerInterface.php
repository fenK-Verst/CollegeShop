<?php


namespace App\Db\Interfaces;


use App\Entity\EntityInterface;

interface ObjectDataManagerInterface
{
    public function __construct(ArrayDataManagerInterface $array_data_manager,ConnectionInterface $connection);

    public function save(EntityInterface $entity);

    public function delete(EntityInterface $entity):bool;

    public function fetchRow(string $query, string $class_name):EntityInterface;

    public function fetchAllArray(string $query, string $class_name):array;

    public function fetchAllHash(string $query, string $class_name, string $hash):array;

    public function getArrayDataManager():ArrayDataManagerInterface;
}