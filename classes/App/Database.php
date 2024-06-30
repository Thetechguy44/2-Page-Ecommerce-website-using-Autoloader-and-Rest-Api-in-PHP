<?php

namespace App;

class Database
{
    protected $connection;

    public function __construct(array $config)
    {
        $this->connect($config);
    }

    protected function connect($config)
    {
        try {
            $this->connection = new \PDO(
                "mysql:host={$config['host']};dbname={$config['database']}",
                $config['username'],
                $config['password']
            );

            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
