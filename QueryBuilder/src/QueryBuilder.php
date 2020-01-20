<?php

namespace App;

use PDO;

class QueryBuilder
{

    private $from;
    private $keys = [];
    private $orderBy = [];
    private $limit;
    private $offset;
    private $condition;
    private $params = [];

    const PER_PAGE = 10;


    public function __construct()
    { }

    public function toSQL(): string
    {

        /* KEYS */

        $keys = (!empty($this->keys)) ? implode(', ', $this->keys) : "*";

        /* FROM */

        $sql = "SELECT {$keys} FROM {$this->from}";

        /* WHERE */

        if ($this->condition) {
            $sql .= " WHERE {$this->condition}";
        }

        /* ORDER BY */

        if (!empty($this->orderBy)) {
            $orderBy = implode(', ', $this->orderBy);
            $sql .= " ORDER BY {$orderBy}";
        }

        /* LIMIT */

        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }

        /* OFFSET */

        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }


        return $sql;
    }

    public function from(string $table, string $alias = null): self
    {
        $this->from = (is_null($alias)) ? "$table" : "$table $alias";
        return $this;
    }

    public function orderBy(string $key, string $direction): self
    {
        $direction = strtoupper($direction);
        $this->orderBy[] = (!in_array($direction, ['ASC', 'DESC'])) ? $key : "$key $direction";
        return $this;
    }

    public function limit($number): self
    {
        $this->limit = $number;
        return $this;
    }

    public function offset($number): self
    {
        $this->offset = $number;
        return $this;
    }

    public function page($number): self
    {
        $this->offset = (int) (($number - 1) * SELF::PER_PAGE);
        return $this;
    }
    public function where(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function select(...$keys): self
    {
        foreach ($keys as $values) {
            if (is_array($values)) {
                foreach ($values as $value) {
                    $this->keys[] = $value;
                }
            } else {
                $this->keys[] = $values;
            }
        }
        return $this;
    }

    public function fetch(PDO $pdo, string $row): ?string
    {
        $query = $pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $return = $query->fetch(PDO::FETCH_OBJ);
        return !($return) ? null : $return->$row;
    }

    /**
     * TODO
     */
    public function count(PDO $pdo)
    {
        $queryCount = $pdo->prepare($this->toSQL());
        $queryCount->execute($this->params);
        return (int) count($queryCount->fetchAll());
    }
}
