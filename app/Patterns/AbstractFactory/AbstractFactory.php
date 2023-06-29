<?php
declare(strict_types=1);

use AbstractFactory\VehicleFactory;

function clientCode(VehicleFactory $factory)
{
    $car = $factory->createCar();
    $truck = $factory->createTruck();

    $car->drive();
    $truck->load();
}

clientCode(new SmallVehicleFactory());
clientCode(new LargeVehicleFactory());
