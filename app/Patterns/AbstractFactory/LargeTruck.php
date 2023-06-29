<?php
declare(strict_types=1);

use AbstractFactory\Truck;

class LargeTruck implements Truck
{
    public function load(): void
    {
        echo "Loading a large truck.";
    }
}
