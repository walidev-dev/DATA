<?php

namespace App;

use PDO;

class Connexion
{
    private static $pdo = null;

    public static function getPDO()
    {
        if (is_null(self::$pdo)) {
            $dsn = "sqlite:products.db";
            $user = null;
            $password = null;
            try {
                self::$pdo = new PDO($dsn, $user, $password, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }

        return self::$pdo;
    }
}
