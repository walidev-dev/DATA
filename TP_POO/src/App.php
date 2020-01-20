<?php

namespace App;

use Core\Config;
use Core\Database;

class App
{

    private static $_instance;

    /**
     * @var Database
     */
    private $db_instance;

    private $title = "Mon Super Site";

    const FILECONFIG = ROOT.'src'.DS.'Config'.DS.'Config.php';

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public function getDatabase()
    {
        if (is_null($this->db_instance)) {
            $config = Config::getInstance(self::FILECONFIG);
            $this->db_instance = new Database($config->get('db_dsn'), $config->get('db_username'), $config->get('db_password'));
        }
        return $this->db_instance;
    }

    public function getTable($name)
    {
        $className = "App\Tables\\" . ucfirst($name) . "Table";
        return new $className();
    }

    public function notFound()
    {
        header('HTTP/1.0 404 Not Found');
        header('Location: index.php?p=404');
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
