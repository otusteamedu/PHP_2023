<?php

namespace App\Products;

interface ProductInterface
{
    /**
     * Получить название продукта.
     *
     * @return string Название продукта.
     */
    public function getName(): string;

    /**
     * Получить цену продукта.
     *
     * @return float Цена продукта.
     */
    public function getPrice(): float;

    /**
     * Получить список ингредиентов продукта.
     *
     * @return array Список ингредиентов.
     */
    public function getIngredients(): array;
}