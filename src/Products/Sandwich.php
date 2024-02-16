<?php

namespace App\Products;

class Sandwich implements ProductInterface
{
    protected string $name = "Сэндвич";
    protected float $price = 4.99;
    protected array $ingredients = ['Хлеб', 'Ветчина', 'Сыр', 'Листья салата'];

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