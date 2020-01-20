<?php

namespace App;

use PDO;

class PaginatedQuery
{
    private $query;
    /**
     * @var int
     */
    private $queryCount;
    private $classMapping;
    private $pdo;
    private $perPage;
    /**
     * @var int
     */
    private $pagesCount;

    public function __construct(
        string $query,
        string $queryCount,
        ?PDO $pdo = null,
        int $perPage = 12
    ) {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems($classMapping): array
    {

        if (!filter_var($this->getCurrentPage(), FILTER_VALIDATE_INT) || $this->getCurrentPage() < 1) {
            throw new Exception("Numéro de page invalide");
        }

        $this->queryCount = (int) $this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM)[0];
        $this->pagesCount = (int) (ceil($this->queryCount / $this->perPage));
        $offset = (int) (($this->getCurrentPage() - 1) * $this->perPage);

        if ($this->getCurrentPage() > $this->pagesCount) {
            throw new Exception("Numéro de page invalide");
        }

        $this->query .= " LIMIT {$this->perPage} OFFSET {$offset}";
        return $this->pdo->query($this->query)->fetchAll(PDO::FETCH_CLASS, $classMapping);
    }

    public function getPagesCount(): int
    {
        return $this->pagesCount;
    }

    public function getCurrentPage(): int
    {
        return (int) ($_GET['page'] ?? 1);
    }

    public function previousLink()
    {
        if ($this->getCurrentPage() <= 1) return null;
        $p = $this->getCurrentPage() - 1;
        $url = "?page=$p";

        return <<<HTML
        <a href="{$url}" class="btn btn-primary">&laquo;Page précédente</a>
HTML;
    }
    public function nextLink()
    {
        if ($this->getCurrentPage() >= $this->getPagesCount()) return null;
        $p = $this->getCurrentPage() + 1;
        $url = "?page=$p";

        return <<<HTML
        <a href="{$url}" class="btn btn-primary">Page suivante&raquo;</a>
HTML;
    }
}
