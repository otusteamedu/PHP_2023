<?php

declare(strict_types=1);

namespace Patterns\Daniel\Products;

class Burger implements ProductInterface
{
    protected string $name = "Burger";
    protected float $price = 5.99;
    protected array $ingredients = ['Bun', 'Cutlet', 'Cheese', 'Salad', 'Tomato'];

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