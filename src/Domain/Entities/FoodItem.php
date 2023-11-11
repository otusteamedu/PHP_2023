<?php

declare(strict_types=1);

namespace User\Php2023\Domain\Entities;

use User\Php2023\Domain\Interfaces\Food;
use User\Php2023\Domain\ObjectValues\FoodType;

abstract class FoodItem implements Food {
    private static array $count = [];
    public int $number;
    public FoodType $type;

    public function __construct(FoodType $type) {
        $class = static::class;
        if (!isset(self::$count[$class])) {
            self::$count[$class] = 0;
        }
        self::$count[$class]++;
        $this->number = self::$count[$class];
        $this->type = $type;
    }

    public function adding(): void
    {
        $foodName = $this->type->getFoodName();
        echo "[$foodName] #$this->number идет добавление ...\n";
        echo "[$foodName] #$this->number добавлен.\n";
    }
}
