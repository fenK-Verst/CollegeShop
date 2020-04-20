<?php


namespace App\Db;


use App\Db\Interfaces\ArrayDataManagerInterface;
use App\Db\Interfaces\ConnectionInterface;
use App\Entity\EntityInterface;

class ObjectDataManager implements Interfaces\ObjectDataManagerInterface
{
    private ArrayDataManagerInterface $arrayDataManager;
    private ConnectionInterface $connection;

    public function __construct(ArrayDataManagerInterface $array_data_manager, ConnectionInterface $connection)
    {
        $this->arrayDataManager = $array_data_manager;
        $this->connection = $connection;
    }

    public function save(EntityInterface $entity)
    {
        $primary_key = $entity->getPrimaryKeyValue();
        if (!is_null($primary_key)){
            $this->update($entity);
        }else{
            $this->create($entity);
        }
    }

    public function delete(EntityInterface $entity): bool
    {
        $table_name = $entity->getTableName();
        $primary_key = $entity->getPrimaryKey();
        $primary_key_value = $entity->getPrimaryKeyValue();
        return (bool) $this->getArrayDataManager()->delete($table_name, [
            $primary_key=>$primary_key_value
        ]);
    }

    public function fetchRow(string $query, string $class_name): EntityInterface
    {

        $result = $this->query($query);
        /**
         * @var EntityInterface $row
         */
        $row = $result->fetch_object($class_name);

        return  $row;
    }

    public function fetchAllArray(string $query, string $class_name): array
    {

        $query_result = $this->query($query);
        $result = [];
        while($row = $result->fetch_object($class_name)){
            $result[] = $row;
        };

        return  $result;
    }

    public function fetchAllHash(string $query, string $class_name, string $hash)
    {
        $query_result = $this->query($query);
        $result = [];
        /**
         * @var EntityInterface $row
         */
        while($row = $result->fetch_object($class_name)){
            $key = $row->getColumnValue($hash);
            $result[$key] = $row;
        };

        return  $result;
    }

    public function getArrayDataManager(): ArrayDataManagerInterface
    {
        return $this->arrayDataManager;
    }
    public function getConnection()
    {
        return $this->connection;
    }
    public function getConnect()
    {
        return $this->getConnection()->getConnection();
    }
    private function query(string $query)
    {
        return $this->getConnect()->query($query);
    }

    private function update(EntityInterface $entity)
    {
        $columns = $entity->getColumns();
        $properties = [];
        foreach ($columns as $column){
            $value = $entity->getColumnValue($column);
            $properties[$column] = $value;
        }
        $table_name = $entity->getTableName();
        $primary_key = $entity->getPrimaryKey();
        $primary_key_value = $entity->getPrimaryKeyValue();

        return (bool)$this->getArrayDataManager()->update($table_name, $properties, [
            $primary_key=>$primary_key_value
        ]);

    }

    private function create(EntityInterface $entity)
    {
        $columns = $entity->getColumns();
        $properties = [];
        foreach ($columns as $column){
            $value = $entity->getColumnValue($column);
            $properties[$column] = $value;
        }
        $table_name = $entity->getTableName();


        return (bool)$this->getArrayDataManager()->insert($table_name, $properties);
    }

}