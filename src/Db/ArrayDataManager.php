<?php


namespace App\Db;


use App\Db\Exceptions\MysqliException;
use App\Db\Interfaces\ConnectionInterface;

class ArrayDataManager implements Interfaces\ArrayDataManagerInterface
{
    private \mysqli $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection->getConnection();
    }

    private function query(string $query): \mysqli_result
    {
        $result = $this->connection->query($query);
        if ($this->connection->errno) {
            $error = $this->connection->error;
            $erno = $this->connection->errno;
            throw new MysqliException("Mysqli error:$error. Error code:$erno ");
        }
        return $result;

    }

    private function escape(string $string): string
    {
        return $this->connection->escape_string($string);
    }

    public function insert(string $table_name, array $values): int
    {

        $query_keys = array_keys($values);
        $query_values = array_values($values);

        $query_keys = array_map(function ($item) {
            return $this->escape($item);
        }, $query_keys);
        $query_values = array_map(function ($item) {
            return '"' . $this->escape($item) . '"';
        }, $query_values);

        $query_keys = implode(",", $query_keys);
        $query_values = implode(",", $query_values);

        $query = "INSERT INTO $table_name($query_keys) VALUES($query_values)";

        $result = $this->query($query);

        return $this->connection->affected_rows;

    }

    public function update(string $table_name, array $values, array $where): int
    {
        foreach ($values as $key => $value) {
            $set_array[] = $key . ' = "' . $this->escape($value) . '"';
        }
        foreach ($where as $key => $value) {
            $where_array[] = $key . ' = "' . $this->escape($value) . '"';
        }


        $query_where = implode("AND ", $where_array);
        $query_set = implode(", ", $set_array);

        $query = "UPDATE $table_name SET $query_set WHERE $query_where";

        $this->query($query);

        return $this->connection->affected_rows;
    }

    public function delete(string $table_name, array $where): int
    {

        foreach ($where as $key => $value) {
            $where_array[] = $key . ' = "' . $this->escape($value) . '"';
        }

        $query_where = implode("AND ", $where_array);

        $query = "DELETE FROM $table_name  WHERE $query_where";

        $this->query($query);

        return $this->connection->affected_rows;
    }
    private function fetch(string $table_name, array $select = [], array $where = []):\mysqli_result
    {
        $array_select = $select;
        $array_select = array_map(function ($value) {
            return $this->escape($value);
        }, $array_select);
        $query_select = implode(",", $array_select);

        if (!$query_select) $query_select = "*";
        $query = "SELECT $query_select  FROM $table_name";
        if (!empty($where)) {
            $where_array = [];
            foreach ($where as $key => $value) {
                $where_array[] = $key . ' = "' . $this->escape($value) . '"';
            }

            $query_where = implode("AND ", $where_array);

            $query .= " WHERE " . $query_where;
        }

        return $this->query($query);

    }
    public function fetchAllHash(string $query, string $hash):array
    {
        $query_result  = $this->query($query);
        $query_result = $query_result->fetch_all(MYSQLI_ASSOC) ?? [];
        $result = [];
        foreach ($query_result as $value){
            $hashed_value = $value[$hash];
            $result[$hashed_value] = $value;
        }
        return  $result;
    }

    public function fetchAllArray(string $query): array
    {
        $query_result  = $this->query($query);
        return  $query_result->fetch_all(MYSQLI_ASSOC) ?? [];
    }
}