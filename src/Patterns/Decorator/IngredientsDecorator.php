<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Decorator;

use Patterns\Daniel\Products\ProductInterface;

class IngredientsDecorator extends ProductDecorator
{
    private string $ingredient;

    private float $price;

    public function __construct(ProductInterface $product, string $ingredient, float $price)
    {
        parent::__construct($product);
        $this->ingredient = $ingredient;
        $this->price = $price;
    }

    public function getName(): string
    {
        return parent::getName() . " + " . $this->ingredient;
    }

    public function getPrice(): float
    {
        return parent::getPrice() + $this->price;
    }

    public function getIngredients(): array
    {
        $ingredients = parent::getIngredients();
        $ingredients[] = $this->ingredient;
        return $ingredients;
    }
}
