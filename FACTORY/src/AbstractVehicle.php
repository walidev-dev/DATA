<?php

namespace App;

abstract class AbstractVehicle
{
    protected $cars = [];

    public function __construct(?array $cars = [])
    {
        $this->cars = array_merge($this->cars, $cars);
    }

    abstract public function call();
}
