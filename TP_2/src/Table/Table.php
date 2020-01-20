<?php

namespace App\Table;

use PDO;

abstract class Table
{
    /**
     * @var PDO
     */
    protected $pdo;

    protected $table;

    protected $entity;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $parts = explode('\\', get_class($this));
        $this->table = strtolower(str_replace('Table', '', end($parts)));
        $this->entity = "App\\Models\\" . str_replace('Table', '', end($parts));
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id= :id");
        $query->execute(['id' => $id]);
        $result = $query->fetchObject($this->entity);
        if ($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    public function deleteById(int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute([':id' => $id]);
    }

    /**
     * @param string $field recherched field
     * @param string $value value of field
     */
    public function exists(string $field, $value, int $id = null): bool
    {
        $sql = "SELECT count(id) FROM {$this->table} WHERE $field = :value";
        $params = [':value' => $value];
        if ($id !== null) {
            $sql .= " AND id != :id";
            $params = array_merge($params, [':id' => $id]);
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        $count = (int) $query->fetch(PDO::FETCH_NUM)[0];
        return ($count > 0) ? true : false;
    }
}
