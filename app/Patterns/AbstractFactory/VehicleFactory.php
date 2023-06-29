<?php
declare(strict_types=1);

namespace AbstractFactory;

interface VehicleFactory
{
    public function createCar(): Car;
    public function createTruck(): Truck;
}