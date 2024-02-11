<?php

declare(strict_types=1);

namespace src\Domain\Entity\Food;

class HotDog extends FoodAbstract
{
    function wrap(): string
    {
        return 'Завернут в бумагу';
    }
}
