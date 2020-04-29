<?php


namespace App\Db;


use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Entity\AbstractEntity;
use App\Entity\EntityInterface;

class ObjectManager implements Interfaces\ObjectManagerInterface
{
    private ObjectDataManagerInterface $objectDataManager;

    private static string $proxy_namespace = "App\\Entity\\Proxy\\";

    public function __construct(ObjectDataManagerInterface $object_data_manager)
    {
        $this->objectDataManager = $object_data_manager;
    }


    public function remove(EntityInterface $entity): bool
    {
        $this->removeDependencies($entity);
        return $this->getObjectDataManager()->delete($entity);
    }

    public function addDependenciesToEntity(EntityInterface $entity): EntityInterface
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
            $repository = new $repository_class($this, $proxy_class);

            if ($needed_entity_primary_key_value){
                $needed_entity = new $proxy_class($repository, $needed_entity_primary_key_value);
            }else{
                $needed_entity = null;
            }

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
            $temp_entity_primary_key = $temp_entity->getPrimaryKey();
            $query = "SELECT $temp_entity_primary_key FROM $table_name WHERE $primary_key = $entity_primary_key_value";
            $objects = $adm->query($query);

            $repository_class = $temp_entity->getRepositoryClass();
            $repository = new $repository_class($this, $proxy_class);
            $adder = $this->getPropertyAdder($entity, $property_name);
            /**
             * @var \mysqli_result $objects
             */
            while ($id = $objects->fetch_row()) {
                if (is_array($id)) $id = $id[0];
                if ($id){
                    $needed_entity = new $proxy_class($repository, $id);
                    $entity->{$adder}($needed_entity);
                }

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
            $repository = new $repository_class($this, $proxy_class);
            $adder = $this->getPropertyAdder($entity, $property_name);
            /**
             * @var \mysqli_result $objects
             */
            while ($id = $objects->fetch_row()) {
                if (is_array($id)) $id = $id[0];
                if ($id){
                    $needed_entity = new $proxy_class($repository, $id);
                    $entity->{$adder}($needed_entity);
                }

            }
        }
        return $entity;
    }

    public function save(EntityInterface $entity): EntityInterface
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

    private function removeDependencies(EntityInterface $entity)
    {
        $dependencies = $this->getEntityDependencies($entity);
        $otm_dep = $dependencies["otm"];
        $mtm_dep = $dependencies["mtm"];

        foreach ($otm_dep as $dep) {
            $entity_class = $dep["entity"];
            $primary_key = $dep["primary_key"];
            $property_name = $dep["property"];
            $adm = $this->getObjectDataManager()->getArrayDataManager();
            $temp_entity = new $entity_class();
            $table_name = $temp_entity->getTableName();
            $primary_key_value = $entity->getPrimaryKeyValue();
            $query = "UPDATE $table_name SET".'`'.$primary_key.'`'. "= NULL WHERE $primary_key=\"$primary_key_value\"";
            $adm->query($query);
        }
        foreach ($mtm_dep as $dep) {
            $self_primary_key = $dep['self_primary_key'];
            $self_primary_key_value = $entity->getPrimaryKeyValue();
            $entity_primary_key = $dep['entity_primary_key'];
            $table_name = $dep['table_name'];
            $property_name = $dep['property'];
            $adm = $this->getObjectDataManager()->getArrayDataManager();
            $query = "DELETE FROM $table_name WHERE ".'`'.$self_primary_key.'`'." =\"$self_primary_key_value\"";
            $adm->query($query);

        }
    }

    private function getEntityProxy(string $class_name)
    {
        $class = explode('\\', $class_name);
        $name = end($class);

        return $this::$proxy_namespace . ucfirst($name) . "Proxy";
    }

    private function getEntityDependencies(EntityInterface $entity)
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

    private function getPropertyGetter(EntityInterface $entity, string $property)
    {
        return $this->getPropertyMethod($entity, "get", $property);
    }

    private function getPropertySetter(EntityInterface $entity, string $property)
    {
        return $this->getPropertyMethod($entity, "set", $property);
    }

    private function getPropertyAdder(EntityInterface $entity, string $property)
    {
        return $this->getPropertyMethod($entity, "add", substr($property, 0, -1));
    }

    public function getObjectDataManager():ObjectDataManagerInterface
    {
        return $this->objectDataManager;
    }


}