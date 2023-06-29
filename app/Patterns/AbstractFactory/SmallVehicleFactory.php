<?php
declare(strict_types=1);

use AbstractFactory\Car;
use AbstractFactory\Sedan;
use AbstractFactory\SmallTruck;
use AbstractFactory\Truck;
use AbstractFactory\VehicleFactory;

class SmallVehicleFactory implements VehicleFactory
{
    public function createCar(): Car
    {
        return new Sedan();
    }

    public function createTruck(): Truck
    {
        return new SmallTruck();
    }
}
