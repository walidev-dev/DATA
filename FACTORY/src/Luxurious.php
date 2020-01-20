<?php

namespace App;

class Luxurious extends AbstractVehicle
{
    protected $cars = ['Mercedes', 'BMW', 'Bently'];

    public function call()
    {
        return 'A ' . $this->cars[array_rand($this->cars)] . ' car is coming to get you (luxurious)';
    }
}
