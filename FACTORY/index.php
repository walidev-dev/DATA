<?php

use App\VehicleFactory;

require_once 'vendor/autoload.php';

$lowCost = VehicleFactory::getVehicle('Low-Cost');
$luxurious = VehicleFactory::getVehicle('Luxurious');

echo "<pre>";
var_dump($lowCost->call(), $luxurious->call());
echo "</pre>";
