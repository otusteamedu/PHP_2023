<?php

namespace App\Ingredients;

class Pepper implements IngredientInterface
{
    public function getName(): string
    {
        return "Перец";
    }

    public function getExtraCost(): float
    {
        return 0.40; // Дополнительная стоимость перца
    }
}