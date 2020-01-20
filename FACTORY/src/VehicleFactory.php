<?php

namespace App;

use Exception;

class VehicleFactory
{

    public static function getVehicle(string $type): AbstractVehicle
    {
        switch ($type) {
            case 'Luxurious':
                return new Luxurious();
                break;
            case 'Low-Cost':
                return new LowCost();
                break;
            default:
                throw new Exception("Type is not valid");
                break;
        }
    }
}
