<?php

namespace App\Patterns\Decorator;

use App\Products\ProductInterface;

class IngredientsDecorator extends ProductDecorator
{
    /**
     * @var string
     */
    private string $ingredient;

    /**
     * @var float
     */
    private float $price;

    /**
     * Конструктор декоратора ингредиентов.
     *
     * @param ProductInterface $product Оборачиваемый продукт.
     * @param string $ingredient Название добавляемого ингредиента.
     * @param float $price Цена добавляемого ингредиента.
     */
    public function __construct(ProductInterface $product, string $ingredient, float $price)
    {
        parent::__construct($product);
        $this->ingredient = $ingredient;
        $this->price = $price;
    }

    /**
     * Получить название продукта с добавленным ингредиентом.
     *
     * @return string
     */
    public function getName(): string
    {
        return parent::getName() . " + " . $this->ingredient;
    }

    /**
     * Получить цену продукта с учетом добавленного ингредиента.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return parent::getPrice() + $this->price;
    }

    /**
     * Получить список ингредиентов продукта с добавленным ингредиентом.
     *
     * @return array
     */
    public function getIngredients(): array
    {
        $ingredients = parent::getIngredients();
        $ingredients[] = $this->ingredient;
        return $ingredients;
    }
}