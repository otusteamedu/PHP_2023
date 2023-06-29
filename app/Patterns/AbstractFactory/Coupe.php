<?php
declare(strict_types=1);

namespace AbstractFactory;

class Coupe implements Car
{

    public function drive(): void
    {
        echo "Driving a coupe car.";
    }
}
