<?php

namespace Cases\Php2023\Domain\Pattern\Factory;

use Cases\Php2023\Domain\Aggregates\Interface\DishCreationStrategyInterface;
use Cases\Php2023\Domain\Pattern\Strategy\BurgerCreationStrategy;
use Cases\Php2023\Domain\Pattern\Strategy\HotDogCreationStrategy;
use Cases\Php2023\Domain\Pattern\Strategy\SandwichCreationStrategy;
use InvalidArgumentException;

class DishCreationStrategyFactory {
    public static function makeStrategy($type): DishCreationStrategyInterface
    {
        return match ($type) {
            "burger" => new BurgerCreationStrategy(),
            "hotdog" => new HotDogCreationStrategy(),
            "sandwich" => new SandwichCreationStrategy(),
            default => throw new InvalidArgumentException("Unknown dish type: " . $type),
        };
    }
}