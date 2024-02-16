<?php

declare(strict_types=1);

namespace Patterns\Daniel\Products;

class Sandwich implements ProductInterface
{
    protected string $name = "Sandwich";
    protected float $price = 4.99;
    protected array $ingredients = ['Bread', 'Ham', 'Cheese', 'Lettuce'];

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