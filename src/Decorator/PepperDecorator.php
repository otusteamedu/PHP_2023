<?php

declare(strict_types=1);

namespace App\Decorator;

class PepperDecorator extends FoodDecorator
{
    public function getIngredients(): array
    {
        $ingredients = parent::getIngredients();
        $ingredients[] = 'pepper';
        return $ingredients;
    }
}
