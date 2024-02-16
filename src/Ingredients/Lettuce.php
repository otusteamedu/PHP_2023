<?php

namespace App\Ingredients;

class Lettuce implements IngredientInterface
{
    public function getName(): string
    {
        return "Салат";
    }

    public function getExtraCost(): float
    {
        return 0.50; // Дополнительная стоимость салата
    }
}