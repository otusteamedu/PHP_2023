<?php
declare(strict_types=1);

// Abstract product A
interface Car
{
    public function drive(): void;
}

// Abstract product B
interface Truck
{
    public function load(): void;
}

// Concrete product A1
class Sedan implements Car
{
    public function drive(): void
    {
        echo "Driving a sedan car.";
    }
}

// Concrete product A2
class Coupe implements Car
{
    public function drive(): void
    {
        echo "Driving a coupe car.";
    }
}

// Concrete product B1
class SmallTruck implements Truck
{
    public function load(): void
    {
        echo "Loading a small truck.";
    }
}

// Concrete product B2
class LargeTruck implements Truck
{
    public function load(): void
    {
        echo "Loading a large truck.";
    }
}

// Abstract Factory
interface VehicleFactory
{
    public function createCar(): Car;
    public function createTruck(): Truck;
}

// Concrete Factory 1
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

// Concrete Factory 2
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

function clientCode(VehicleFactory $factory)
{
    $car = $factory->createCar();
    $truck = $factory->createTruck();

    $car->drive();
    $truck->load();
}

clientCode(new SmallVehicleFactory());
clientCode(new LargeVehicleFactory());
