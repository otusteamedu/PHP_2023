<?php

namespace Cases\Php2023\Domain\Pattern\Factory;

use Cases\Php2023\Domain\Aggregates\Burger\Burger;
use Cases\Php2023\Domain\Aggregates\HotDog\HotDog;
use Cases\Php2023\Domain\Aggregates\Interface\DishInterface;
use Cases\Php2023\Domain\Aggregates\Sandwich\Sandwich;
use http\Exception\InvalidArgumentException;

class DishFactory
{
    public static function createDishClassic($type): DishInterface
    {
        return match ($type) {
            'Burger' => Burger::createClassic(),
            'Bread' => Sandwich::createClassic(),
            'HotDog' => HotDog::createClassic(),
            default => throw new InvalidArgumentException('invalid'),
        };

    }
}