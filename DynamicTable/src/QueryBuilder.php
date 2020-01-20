<?php

namespace App;

use PDO;

class QueryBuilder
{
    private $from;

    private $order = [];

    private $limit;

    private $offset;

    private $page;

    private $where;

    private $params = [];

    private $fields = ["*"];


    const PER_PAGE = 10;

    private $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function from(string $table, string $alias = null): self
    {
        $this->from = ($alias === null) ? $table : "$table $alias";
        return $this;
    }

    public function orderBy(string $key, string $direction): self
    {
        $direction = strtoupper($direction);
        $this->order[] = (!in_array($direction, ['ASC', 'DESC'])) ? $key : "$key $direction";
        return $this;
    }

    public function limit(int $number): self
    {
        $this->limit = $number;
        return $this;
    }

    public function offset(int $number): self
    {
        $this->offset = $number;
        return $this;
    }

    public function page(int $number): self
    {
        $this->offset = (int) (($number - 1) * $this->limit);
        return $this;
    }

    public function where(string $condition): self
    {
        $this->where = $condition;
        return $this;
    }

    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }

    public function select(...$fields): self
    {
        if (is_array($fields[0])) {
            $fields = $fields[0];
        }
        if ($this->fields === ["*"]) {
            $this->fields = $fields;
        } else {
            $this->fields = array_merge($this->fields, $fields);
        }

        return $this;
    }

    public function fetch(string $fields): ?string
    {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($result === false) {
            return null;
        }
        return $result->$fields ?? null;
    }
    public function fetchAll(): array
    {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function count(): int
    {
        /* $this->fields = array_merge($this->fields, ["COUNT(id) count"]);
        $count = $this->fetch($pdo, 'count');
        array_pop($this->fields);
        return (int) $count; */

        $query = clone $this;
        return (int) $query->select("COUNT(id) count")->fetch('count');
    }

    public function toSQL(): string
    {

        /* FIELDS */

        $fields = implode(', ', $this->fields);

        /*  FROM  */

        $sql = "SELECT {$fields} FROM {$this->from}";

        /* WHERE */
        if ($this->where) {
            $sql .= " WHERE {$this->where}";
        }

        /* OREDR BY */

        if (!empty($this->order)) {
            $sql .= " ORDER BY " . implode(', ', $this->order);
        }

        /* LIMIT */

        if ($this->limit > 0) {
            $sql .= " LIMIT {$this->limit}";
        }

        /* OFFSET */

        if ($this->offset !== null) {
            $sql .= " OFFSET {$this->offset}";
        }




        return $sql;
    }
}
