<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Entity\AbstractEntity;
use App\Entity\EntityInterface;
use App\Repository\Exceptions\GivenEntityNotAbstractEntityException;

abstract class AbstractRepository //implements RepositoryInterface
{
    private ObjectDataManagerInterface $objectDataManager;
    private AbstractEntity $entity;

    public function __construct(ObjectDataManagerInterface $object_data_manager, string $entity_class)
    {

        if (!class_exists($entity_class) || !in_array(AbstractEntity::class, class_parents($entity_class))) {
            throw new GivenEntityNotAbstractEntityException("Entity $entity_class  should be AbstractEntity");
        }
        $this->objectDataManager = $object_data_manager;
        $this->entity = new $entity_class();
    }

    public function findAll(): array
    {
        return $this->findBy([]);
    }

    public function findBy(array $where, array $order = [], array $limit = []): array
    {
        $where_array = [];
        foreach ($where as $key => $value) {
            $where_array[] = $this->escape($key) . ' = "' . $this->escape($value) . '"';
        }
        $table_name = $this->entity->getTableName();
        $query = "SELECT * FROM $table_name";

        if (!empty($where_array)) {
            $where_query = implode("AND", $where_array);
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

        return $this->getObjectDataManager()->fetchAllHash($query, $class_name, $hash);
    }

    public function remove(EntityInterface $entity): bool
    {
        return $this->getObjectDataManager()->delete($entity);
    }

    public function find(string $primary_key_value): ?EntityInterface
    {
        $primary_key = $this->entity->getPrimaryKey();
        $result = $this->findBy([
            $primary_key => $primary_key_value
        ]);
        $entity = array_values($result)[0];
        if (!$entity) return null;
//        $entity = $this->addDependenciesToEntity($entity);
        return $entity;
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

    public function getObjectDataManager(): ObjectDataManagerInterface
    {
        return $this->objectDataManager;
    }

    private function escape(string $string): string
    {
        return $this->getObjectDataManager()->getArrayDataManager()->escape($string);
    }
    private function addDependenciesToEntity(AbstractEntity $entity):AbstractEntity
    {
        $dependencies = $this->getEntityDependencies($entity);
        var_dump($dependencies);

        return $entity;
    }
    private function getEntityDependencies(AbstractEntity $entity)
    {
        $dependencies = [
            "mto" => [],
            "otm" => [],
            "mtm" => []
        ];
        $reflection_class = new \ReflectionClass($entity);
        $reflection_properties = $reflection_class->getProperties();
        foreach ($reflection_properties as $property) {
            $doc = $property->getDocComment();
            $mto = $this->getParamsFromDoc("Entity\\\ManyToOne", $doc);
            $otm = $this->getParamsFromDoc("Entity\\\OneToMany", $doc);
            $mtm = $this->getParamsFromDoc("Entity\\\ManyToMany", $doc);

            if (!empty($mto)) $dependencies["mto"][] = $mto;
            if (!empty($otm)) $dependencies["otm"][] = $otm;
            if (!empty($mtm)) $dependencies["mtm"][] = $mtm;
        }
        return $dependencies;
    }

    private function getParamsFromDoc(string $key, string $doc)
    {
        preg_match_all("/@$key\((.*)\)/m", $doc, $finded);

        if (is_null($finded[0][0] ?? null)) return false;
        $params = explode(',', $finded[1][0]);
        $result = [];
        if (is_null($params{1} ?? null)) return [];
        foreach ($params as $param) {
            $param = explode("=", $param);
            $result[trim($param[0])] = trim($param[1], '"');
        }

        return $result;
    }

    private function getPropertyMethod(AbstractEntity $entity, string $method, string $property)
    {
        $property = explode("_", $property);
        $property = array_map(function ($item) {
            return ucfirst($item);
        }, $property);
        $property = implode("", $property);
        $result = "$method$property";
        if (!method_exists($entity, $result)) {
            throw new \Exception("Method $result does not exists");
        }
        return $result;
    }

    private function getPropertyGetter(AbstractEntity $entity, string $property)
    {
        return $this->getPropertyMethod($entity, "get", $property);
    }

    private function getPropertySetter(AbstractEntity $entity, string $property)
    {
        return $this->getPropertyMethod($entity, "set", $property);
    }

    private function getPropertyAdder(AbstractEntity $entity, string $property)
    {
        return $this->getPropertyMethod($entity, "add", $property);
    }
}