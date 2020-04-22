<?php


namespace App\Db\Interfaces;


interface ArrayDataManagerInterface
{
    public function query(string $query);

    public function insert(string $table_name, array $values): int;

    public function update(string $table_name, array $values, array $where): int;

    public function delete(string $table_name, array $where): int;

    public function fetchAllHash(string $query, string $hash): array;

    public function fetchAllArray(string $query): array;

    public function escape(string $string):string;


}