<?php

namespace App\Models;

use LogicException;

class Product
{
    const FOOD_PRODUCT = 'food';

    private $name;

    private $type;

    private $price;

    public function __construct($name, $type, $price)
    {
        $this->name = $name;
        $this->type = $type;
        $this->price = $price;
    }

    public function computeTVA()
    {
        if ($this->price < 0) {
            throw new LogicException("The price cannot be negative.");
        }
        if ($this->type === self::FOOD_PRODUCT) {
            return $this->price * 0.055;
        }

        return $this->price * 0.196;
    }
}
