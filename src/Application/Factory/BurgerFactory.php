<?php

declare(strict_types=1);

namespace src\Application\Factory;

use src\Domain\Entity\Food\Burger;
use src\Domain\Entity\Food\FoodAbstract;

class BurgerFactory implements BasicProductFactoryInterface
{
    public function make(string $filling): FoodAbstract
    {
        return new Burger('Тесто для бургера', $filling);
    }
}
