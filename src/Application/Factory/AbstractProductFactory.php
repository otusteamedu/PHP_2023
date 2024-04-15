<?php

namespace Dmitry\Hw16\Application\Factory;

use Dmitry\Hw16\Domain\Entity\Burger;

interface AbstractProductFactory
{
    public function createBurger(): Burger;

    public function createSandwich(): Sandwich;

    public function createHotDog(): HotDog;
}