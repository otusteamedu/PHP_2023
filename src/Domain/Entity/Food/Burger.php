<?php

declare(strict_types=1);

namespace src\Domain\Entity\Food;

class Burger extends FoodAbstract
{
    public function wrap(): string
    {
        return 'Упакован в коробку';
    }
}
