<?php

namespace App\Ingredients;

interface IngredientInterface
{
    /**
     * Получить название ингредиента.
     *
     * @return string Название ингредиента.
     */
    public function getName(): string;

    /**
     * Получить дополнительную стоимость ингредиента.
     *
     * @return float Дополнительная стоимость.
     */
    public function getExtraCost(): float;
}