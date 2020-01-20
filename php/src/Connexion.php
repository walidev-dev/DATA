<?php

namespace App;;

use PDO;

class Connexion
{
    public static function getPDO()
    {
        $dsn = "sqlite:products.db";
        $user = null;
        $password = null;
        try {
            $pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
        return $pdo;
    }
}
