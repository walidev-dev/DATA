<?php

namespace App;

use PDO;

class App
{

    private static $pdo = null;

    private static $auth = null;


    public static function getPDO(): PDO
    {
        if (is_null(self::$pdo)) {
            self::$pdo = new PDO('sqlite:../data.sqlite', null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$pdo;
    }

    public static function getAuth(): Auth
    {
        if (is_null(self::$auth)) {
            self::$auth = new Auth(App::getPDO(), "login.php", $_SESSION);
        }
        return self::$auth;
    }
}
