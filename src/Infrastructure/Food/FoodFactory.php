<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Food;

use User\Php2023\Domain\Entities\Burger;
use User\Php2023\Domain\Entities\HotDog;
use User\Php2023\Domain\Entities\Sandwich;
use User\Php2023\Domain\Interfaces\Food;
use User\Php2023\Domain\ObjectValues\FoodType;

class FoodFactory {
    public function createFood(FoodType $type): Food
    {
        return match ($type) {
            FoodType::BURGER => new Burger(),
            FoodType::SANDWICH => new Sandwich(),
            FoodType::HOTDOG => new HotDog(),
        };
    }
}
