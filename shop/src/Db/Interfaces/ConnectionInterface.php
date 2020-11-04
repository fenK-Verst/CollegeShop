<?php


namespace App\Db\Interfaces;


interface ConnectionInterface
{
    public function __construct(string $host, string $user, string $password, string $db_name, string $port="3306");

    public function getConnection();
}