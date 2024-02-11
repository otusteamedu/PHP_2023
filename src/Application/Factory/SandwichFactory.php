<?php

declare(strict_types=1);

namespace src\Application\Factory;

use src\Domain\Entity\Food\FoodAbstract;
use src\Domain\Entity\Food\Sandwich;

class SandwichFactory implements BasicProductFactoryInterface
{

    public function make(string $filling): FoodAbstract
    {
        return new Sandwich('тесто для сендвича', $filling);
    }
}
