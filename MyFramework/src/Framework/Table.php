<?php

namespace Framework;

use App\Blog\Entities\Post;
use PDO;

abstract class Table
{
    protected $pdo;
    protected $table;
    protected $classMapping;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $parts = explode('\\', get_class($this));
        $this->table = strtolower(str_replace('Table', '', end($parts)));
    }

    public function getOne(int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id =:id');
        $query->execute(['id' => $id]);
        return $query->fetchObject($this->classMapping);
    }

    public function getAll()
    {
        return $this->pdo
            ->query('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC')
            ->fetchAll(PDO::FETCH_CLASS, $this->classMapping);
    }

}
