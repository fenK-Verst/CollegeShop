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
    private static string $proxy_namespace = "App\\Entity\\Proxy\\";

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

    public function save(EntityInterface $entity): EntityInterface
    {
        $entity = $this->saveEntityDependencies($entity);
//        $entity = $this->getObjectDataManager()->save($entity);
        return $entity;
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
        $entity = array_values($result)[0] ?? null;
        if (!$entity) return null;
        $entity = $this->addDependenciesToEntity($entity);
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

    private function addDependenciesToEntity(EntityInterface $entity): EntityInterface
    {
        $dependencies = $this->getEntityDependencies($entity);
        $mto_dep = $dependencies["mto"];
        $otm_dep = $dependencies["otm"];
        $mtm_dep = $dependencies["mtm"];
        foreach ($mto_dep as $dep) {
            $needed_entity_class = $dep["entity"];
            $needed_primary_key = $dep["primary_key"];
            $property_name = $dep["property"];
            $needed_entity_primary_key_value = $entity->{$needed_primary_key};
            $proxy_class = $this->getEntityProxy($needed_entity_class);
            /**
             * @var AbstractEntity $temp_entity
             */
            $temp_entity = new $needed_entity_class();

            $repository_class = $temp_entity->getRepositoryClass();
            $repository = new $repository_class($this->getObjectDataManager(), $proxy_class);
            $needed_entity = new $proxy_class($repository, $needed_entity_primary_key_value);

            $setter = $this->getPropertySetter($entity, $property_name);
            $entity->{$setter}($needed_entity);
        }
        foreach ($otm_dep as $dep) {
            $needed_entity_class = $dep["entity"];
            $primary_key = $dep["primary_key"];
            $property_name = $dep["property"];
            $adm = $this->getObjectDataManager()->getArrayDataManager();
            $entity_primary_key_value = $entity->getPrimaryKeyValue();
            $proxy_class = $this->getEntityProxy($needed_entity_class);
            /**
             * @var AbstractEntity $temp_entity
             */
            $temp_entity = new $needed_entity_class();
            $table_name = $temp_entity->getTableName();

            $query = "SELECT $primary_key FROM $table_name WHERE $primary_key = $entity_primary_key_value";

            $objects = $adm->query($query);

            $repository_class = $temp_entity->getRepositoryClass();
            $repository = new $repository_class($this->getObjectDataManager(), $proxy_class);
            /**
             * @var \mysqli_result $objects
             */
            while ($id = $objects->fetch_row()) {
                $needed_entity = new $proxy_class($repository, $id);
                $adder = $this->getPropertyAdder($entity, $property_name);
                $entity->{$adder}($needed_entity);
            }


        }
        foreach ($mtm_dep as $dep) {
            $needed_entity_class = $dep['entity'];
            $self_primary_key = $dep['self_primary_key'];
            $self_primary_key_value = $entity->getPrimaryKeyValue();
            $entity_primary_key = $dep['entity_primary_key'];
            $table_name = $dep['table_name'];
            $proxy_class = $this->getEntityProxy($needed_entity_class);
            $property_name = $dep['property'];

            $adm = $this->getObjectDataManager()->getArrayDataManager();
            $query = "SELECT $entity_primary_key FROM $table_name WHERE $self_primary_key = $self_primary_key_value";
            $objects = $adm->query($query);

            $temp_entity = new $needed_entity_class();
            $repository_class = $temp_entity->getRepositoryClass();
            $repository = new $repository_class($this->getObjectDataManager(), $proxy_class);
            /**
             * @var \mysqli_result $objects
             */
            while ($id = $objects->fetch_row()) {
                $needed_entity = new $proxy_class($repository, $id[0]);
                $adder = $this->getPropertyAdder($entity, $property_name);
                $entity->{$adder}($needed_entity);
            }
        }
        return $entity;
    }

    private function saveEntityDependencies(EntityInterface $entity): EntityInterface
    {
        $dependencies = $this->getEntityDependencies($entity);
        $mto_dep = $dependencies["mto"];
        $otm_dep = $dependencies["otm"];
        $mtm_dep = $dependencies["mtm"];
        foreach ($mto_dep as $dep) {
            $needed_primary_key = $dep["primary_key"];
            $property_name = $dep["property"];
            $getter = $this->getPropertyGetter($entity, $property_name);
            $saved_entity = $entity->{$getter}();
            if (is_null($saved_entity)) {
                $entity->{$needed_primary_key} = null;
                continue;
            }
            if (!$saved_entity->getPrimaryKeyValue()) {
                $saved_entity = $this->save($saved_entity);
            }
            $entity->{$needed_primary_key} = $saved_entity->getPrimaryKeyValue();
        }

        $e = $this->getObjectDataManager()->save($entity);
        $e_primary_key = $e->getPrimaryKeyValue();
        foreach ($otm_dep as $dep) {

            $primary_key = $dep["primary_key"];
            $property_name = $dep["property"];
            $getter = $this->getPropertyGetter($entity, $property_name);
            $saved_entities = $entity->{$getter}();
            foreach ($saved_entities as $saved_entity) {
                $saved_entity->{$primary_key} = $e_primary_key;
                $this->save($saved_entity);
            }
        }
        foreach ($mtm_dep as $dep) {
            $self_primary_key = $dep['self_primary_key'];
            $self_primary_key_value = $e_primary_key;
            $entity_primary_key = $dep['entity_primary_key'];
            $table_name = $dep['table_name'];
            $property_name = $dep['property'];

            $getter = $this->getPropertyGetter($entity, $property_name);
            $objects = $entity->{$getter}();
            $ids = [];

            foreach ($objects as $object){
                if (!$object->getPrimaryKeyValue()) {
                    $object = $this->save($object);
                }
                $ids[] = $object->getPrimaryKeyValue();
            }
            $adm = $this->getObjectDataManager()->getArrayDataManager();
            $query = "DELETE FROM $table_name WHERE $self_primary_key = $self_primary_key_value";
            $adm->query($query);
            if (!empty($ids)){
                $query_values = [];
                foreach ($ids as $id){
                    $query_values[] = "($self_primary_key_value, $id)";
                }

                $query_values = implode(",", $query_values);
                $query = "INSERT INTO $table_name($self_primary_key, $entity_primary_key) VALUES $query_values";

                $adm->query($query);
            }

        }
        return $e;
    }

    private function getEntityProxy(string $class_name)
    {
        $class = explode('\\', $class_name);
        $name = end($class);

        return $this::$proxy_namespace . ucfirst($name) . "Proxy";
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
            $property_name = $property->getName();
            if (!empty($mto)) {
                $mto["property"] = $property_name;
                $dependencies["mto"][] = $mto;
            }
            if (!empty($otm)) {
                $otm["property"] = $property_name;
                $dependencies["otm"][] = $otm;
            }
            if (!empty($mtm)) {
                $mtm["property"] = $property_name;
                $dependencies["mtm"][] = $mtm;
            }
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

    private function getPropertyMethod($entity, string $method, string $property)
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
        return $this->getPropertyMethod($entity, "add", substr($property, 0, -1));
    }


}