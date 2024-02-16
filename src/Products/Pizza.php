<?php

namespace App\Products;

class Pizza implements ProductInterface
{
    protected string $name = "Пицца";
    protected float $price = 7.99;
    protected array $ingredients = ['Тесто', 'Томатный соус', 'Сыр моцарелла', 'Пепперони'];

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