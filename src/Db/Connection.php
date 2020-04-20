<?php


namespace App\Db;


use App\Db\Exceptions\ConnectionException;
use App\Db\Interfaces\ConnectionInterface;

class Connection implements ConnectionInterface
{
    private ?\mysqli $connection = null;

    private string $host;
    private string $user;
    private string $password;
    private string $db_name;
    private string $port;

    /**
     * Connection constructor.
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db_name
     * @param string $port
     */
    public function __construct(string $host, string $user, string $password, string $db_name, string $port="3306")
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db_name = $db_name;
        $this->port = $port;
    }

    public function getConnection()
    {
        if (is_null($this->connection)){
            $this->connect();
        }
        return $this->connection;
    }

    private function connect()
    {
        $connection = new \mysqli($this->host, $this->user, $this->password, $this->db_name, $this->port);
        if (!$connection || $connection->connect_errno) {
            $error = $connection->connect_error;
            $errno = $connection->connect_errno;
            throw new ConnectionException("$error. Code:$errno");
        }
        $this->connection = $connection;
    }
}