<?php

declare(strict_types=1);

namespace src\Application\Factory;

use src\Domain\Entity\Food\FoodAbstract;

interface BasicProductFactoryInterface
{
    public function make(string $filling): FoodAbstract;
}
