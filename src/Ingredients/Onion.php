<?php

namespace App\Ingredients;

class Onion implements IngredientInterface
{
    public function getName(): string
    {
        return "Лук";
    }

    public function getExtraCost(): float
    {
        return 0.30; // Дополнительная стоимость лука
    }
}