<?php

namespace App\Entities;

abstract class Entity{

    protected $id;

    protected $view;

    public function __construct()
    {
        if (null === $this->view) {
            $parts = explode('\\', get_called_class());
            $parts = end($parts);
            $this->view = strtolower($parts);
        }
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        return $this->$method();
    }

    public function getUrl()
    {
        return "index.php?p={$this->view}&id={$this->id}";
    }
}