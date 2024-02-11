<?php

declare(strict_types=1);

namespace src\Application\Factory;

use src\Domain\Entity\Food\FoodAbstract;
use src\Domain\Entity\Food\HotDog;

class HotDogFactory implements BasicProductFactoryInterface
{

    public function make(string $filling): FoodAbstract
    {
        return new HotDog('тесто для хот-дога', $filling);
    }
}
