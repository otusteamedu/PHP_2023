<?php

namespace App\Domains\Order\Domain\Entity\Product;

use App\Domains\Order\Domain\Entity\Ingredient;

class AbstractProduct
{
    protected array $ingredients = [];

    public function __construct()
    {
    }

    public function addAdditionalIngredient(Ingredient $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function addDefaultIngredients(array $defaultIngredients): void
    {
        $this->ingredients = array_merge($this->ingredients, $defaultIngredients);
    }
}
