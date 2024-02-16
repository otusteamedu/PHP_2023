<?php

declare(strict_types=1);

namespace Patterns\Daniel\Products;

class HotDog implements ProductInterface
{
    protected string $name = "Hot dog";
    protected float $price = 3.99;
    protected array $ingredients = ['Hot dog bun', 'sausage', 'mustard', 'ketchup'];

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
