<?php

namespace App;

use stdClass;

class Table
{
    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    private $get;

    private $formatters = [];

    private $sortable = [];

    private $columns = [];

    private $limit = 20;

    const SORT_KEY = 'sort';

    const DIR_KEY = 'dir';

    public function __construct(QueryBuilder $queryBuilder, array $get)
    {
        $this->queryBuilder = $queryBuilder;
        $this->get = $get;
    }

    public function sortable(string ...$sortable): self
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public  function th(string $key): string
    {
        if (!in_array($key, $this->sortable)) {
            return $this->columns[$key];
        }
        $sort = $this->get[self::SORT_KEY] ?? null;
        $direction = $this->get[self::DIR_KEY] ?? null;
        $icon = "";
        if ($sort === $key) {
            $icon = ($direction === 'asc') ? '^' : 'v';
        }
        $url = URLHelper::withParams(
            $this->get,
            [
                self::SORT_KEY => $key,
                self::DIR_KEY  => ($direction === 'asc' && $sort === $key) ? 'desc' : 'asc',
            ]
        );
        return <<<HTML
        <a href="?$url">{$this->columns[$key]} $icon</a>
HTML;
    }

    public function render()
    {
        $page = (int) ($this->get['p'] ?? 1);
        $itemsCount = (clone $this->queryBuilder)->count();
        if (!empty($this->get['sort']) && in_array($this->get['sort'], $this->sortable)) {
            $this->queryBuilder->orderBy($this->get['sort'], $this->get['dir'] ?? 'asc');
        }

        $items = $this->queryBuilder
            ->select(array_keys($this->columns))
            ->limit($this->limit)
            ->page($page)
            ->fetchAll();

        $pagesCount = (int) ceil($itemsCount / $this->limit);
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <?php foreach ($this->columns as $key => $value) : ?>
                        <th><?= $this->th($key) ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <?php foreach ($this->columns as $key => $value) : ?>
                            <td><?= $this->td($key, $item) ?></td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <?php if ($pagesCount > 1 && $page <= $pagesCount && $page > 1) : ?>
            <a href="?<?= URLHelper::withParam($this->get, "p", $page - 1) ?>" class="btn btn-primary">Page Précédente</a>
        <?php endif ?>
        <?php if ($pagesCount > 1 && $page < $pagesCount) : ?>
            <a href="?<?= URLHelper::withParam($this->get, "p", $page + 1) ?>" class="btn btn-primary">Page Suivante</a>
        <?php endif ?>
        </div>

<?php
    }

    public function addFormatter(string $key, callable $function): self
    {
        $this->formatters[$key] = $function;
        return $this;
    }

    public function td(string $key, stdClass $item): string
    {
        if (isset($this->formatters[$key])) {
            return $this->formatters[$key]($item->$key);
        }
        return $item->$key;
    }
}
