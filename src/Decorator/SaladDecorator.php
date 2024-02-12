<?php

declare(strict_types=1);

namespace App\Decorator;

class SaladDecorator extends FoodDecorator
{
    public function getIngredients(): array
    {
        $ingredients = parent::getIngredients();
        $ingredients[] = 'salad';
        return $ingredients;
    }
}
