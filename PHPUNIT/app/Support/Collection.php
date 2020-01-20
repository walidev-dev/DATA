<?php

namespace App\Support;

class Collection
{
    /**
     * @var Array
     */
    private $items = [];

    public function __construct(?array $items = [])
    {
        $this->items = $items;
    }

    public function get()
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }
}
