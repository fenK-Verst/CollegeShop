<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\AbstractEntity;
use App\Entity\EntityInterface;
use App\Repository\Exceptions\GivenEntityNotAbstractEntityException;

abstract class AbstractRepository //implements RepositoryInterface
{
    private ObjectDataManagerInterface $objectDataManager;
    private AbstractEntity $entity;
    private ObjectManagerInterface $objectManager;

    public function __construct(ObjectManagerInterface $object_manager, string $entity_class)
    {
        if (!class_exists($entity_class) || !in_array(AbstractEntity::class, class_parents($entity_class))) {
            throw new GivenEntityNotAbstractEntityException("Entity $entity_class  should be AbstractEntity");
        }
        $this->objectManager = $object_manager;
        $this->objectDataManager = $object_manager->getObjectDataManager();
        $this->entity = new $entity_class();
    }

    public function find(?string $primary_key_value): ?EntityInterface
    {
        if (is_null($primary_key_value)) return null;
        $primary_key = $this->entity->getPrimaryKey();
        $result = $this->findBy([
            $primary_key => $primary_key_value
        ]);
        return array_values($result)[0] ?? null;

    }

    public function findBy(array $where, array $order = [], array $limit = []): array
    {
        $where_array = [];
        foreach ($where as $key => $value) {
            $where_array[] = '`'.$this->escape($key) .'`' . ' = "' . $this->escape($value) . '"';
        }
        $table_name = $this->entity->getTableName();
        $query = "SELECT * FROM $table_name";

        if (!empty($where_array)) {
            $where_query = implode(" AND ", $where_array);
            $query .= " WHERE $where_query";
        }
        $order_array = [];
        foreach ($order as $key => $value) {
            $order_array[] = $this->escape($key) . ' ' . $this->escape($value);
        }
        if (!empty($order_array)) {
            $order_query = implode(", ", $order_array);
            $query .= " ORDER BY $order_query";
        }
        if (!empty($limit)) {
            $limit_query = '';
            foreach ($limit as $key => $value) {
                $limit_query = (int)$key . ',' . (int)$value;
                break;
            }
            $query .= " LIMIT $limit_query";
        }
        $class_name = get_class($this->entity);
        $hash = $this->entity->getPrimaryKey();

        $objects = $this->objectDataManager->fetchAllHash($query, $class_name, $hash);
        foreach ($objects as &$object) {
            $object = $this->objectManager->addDependenciesToEntity($object);
        }
        return $objects;
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function findOrCreate(string $primary_key_value)
    {
        $result = $this->find($primary_key_value);
        if (!empty($result)) {
            return $result;
        }
        $class_name = get_class($this->entity);
        return new $class_name();

    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
    private function escape(string $string): string
    {
        return $this->objectDataManager->getArrayDataManager()->escape($string);
    }




}