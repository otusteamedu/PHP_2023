<?php

declare(strict_types=1);

namespace src\Domain\Entity\Food;

class Sandwich extends FoodAbstract
{
    function wrap(): string
    {
        return 'Упакован в пластиковую упаковку';
    }
}
