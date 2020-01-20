<?php

namespace Core;

use PDO;

class Database
{
    private $db_dsn;

    private $db_username;

    private $db_password;

    /**
     * @var PDO
     */
    private $pdo = null;

    public function __construct($db_dsn, $db_username, $db_password)
    {
        $this->db_dsn = $db_dsn;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
    }

    private function getPDO()
    {
        if (is_null($this->pdo)) {
            $this->pdo = new PDO($this->db_dsn, $this->db_username, $this->db_password, [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            ]);
        }
        return $this->pdo;
    }

    public function query($statement, $class_name)
    {
        return $this->getPDO()
            ->query($statement)
            ->fetchAll(PDO::FETCH_CLASS, $class_name);
    }

    public function prepare($statement, $params = [], $class_name, $one = false)
    {
        $query = $this->getPDO()->prepare($statement);
        $query->execute($params);
        if ($one) {
            return $query->fetchObject($class_name);
        }
        return $query->fetchAll(PDO::FETCH_CLASS, $class_name);
    }
}
