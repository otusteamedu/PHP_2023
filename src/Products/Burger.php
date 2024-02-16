<?php

namespace App\Products;

class Burger implements ProductInterface
{
    protected string $name = "Бургер";
    protected float $price = 5.99;
    protected array $ingredients = ['Булка', 'Котлета', 'Сыр', 'Салат', 'Помидор'];

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}