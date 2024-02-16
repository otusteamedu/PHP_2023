<?php

declare(strict_types=1);

namespace Patterns\Daniel\Products;

class Pizza
{
    protected string $name = "Pizza";
    protected float $price = 7.99;
    protected array $ingredients = ['Hot dog bun', 'sausage', 'mustard', 'ketchup'];

    public function getPizzaName(): string
    {
        return $this->name;
    }

    public function getPizzaPrice(): float
    {
        return $this->price;
    }

    public function getPizzaIngredients(): array
    {
        return $this->ingredients;
    }
}
