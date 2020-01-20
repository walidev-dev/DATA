<?php

namespace App;

class LowCost extends AbstractVehicle
{
    protected $cars = ['Fiat', 'Renault'];

    public function call()
    {
        return 'A ' . $this->cars[array_rand($this->cars)] . ' car is coming to get you (low cost)';
    }
}
