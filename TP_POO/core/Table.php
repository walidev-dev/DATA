<?php

namespace Core;


use App\App;

abstract class Table
{
    protected $entity;

    protected $table;

    protected $classMapping;

    /**
     * @var Database
     */
    protected $db;

    public function __construct()
    {
        $this->db = App::getInstance()->getDatabase();

        if (null === $this->entity) {
            $parts = explode('\\', get_called_class());
            $parts = end($parts);
            $this->entity = "App\Entities\\".str_replace('Table', '', $parts);
        }

        if (null === $this->table) {
            $parts = explode('\\', get_called_class());
            $parts = end($parts);
            $this->table = strtolower(str_replace('Table', '', $parts));
        }
    }


    public function all()
    {
        return $this->db->query("SELECT * FROM " . $this->table,$this->entity);
    }

    public function find(int $id)
    {
        return $this->db->prepare("SELECT * FROM " . $this->table . " WHERE id =:id", [':id' => $id],$this->entity, true);
    }

    public function delete(int $id)
    { }
}
