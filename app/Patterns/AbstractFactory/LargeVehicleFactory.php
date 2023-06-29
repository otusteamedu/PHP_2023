<?php
declare(strict_types=1);

use AbstractFactory\Car;
use AbstractFactory\Coupe;
use AbstractFactory\Truck;
use AbstractFactory\VehicleFactory;

class LargeVehicleFactory implements VehicleFactory
{
    public function createCar(): Car
    {
        return new Coupe();
    }

    public function createTruck(): Truck
    {
        return new LargeTruck();
    }
}
