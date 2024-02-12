<?php

declare(strict_types=1);

namespace App\Decorator;

class MushroomsDecorator extends FoodDecorator
{
    public function getIngredients(): array
    {
        $ingredients = parent::getIngredients();
        $ingredients[] = 'mushrooms';
        return $ingredients;
    }
}
