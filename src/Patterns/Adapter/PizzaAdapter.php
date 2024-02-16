<?php

namespace App\Patterns\Adapter;

use App\Products\Pizza;
use App\Products\ProductInterface;

class PizzaAdapter implements ProductInterface
{
    /**
     * @var Pizza
     */
    private Pizza $pizza;

    /**
     * Конструктор адаптера пиццы.
     *
     * @param Pizza $pizza Объект пиццы, который нужно адаптировать.
     */
    public function __construct(Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    /**
     * Получить название продукта.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->pizza->getName();
    }

    /**
     * Получить цену продукта.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->pizza->getPrice();
    }

    /**
     * Получить список ингредиентов продукта.
     *
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->pizza->getIngredients();
    }
}