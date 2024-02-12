<?php

declare(strict_types=1);

namespace App\Decorator;

use App\Builder\FoodInterface;

abstract class FoodDecorator implements FoodInterface
{
    protected FoodInterface $food;

    public function __construct(FoodInterface $food)
    {
        $this->food = $food;
    }

    public function getDescription(): string
    {
        return $this->food->getDescription();
    }

    public function getPrice(): float
    {
        return $this->food->getPrice();
    }

    public function getName(): string
    {
        return $this->food->getName();
    }

    public function getIngredients(): array
    {
        return $this->food->getIngredients();
    }

    public function toCook(): string
    {
        return $this->food->toCook();
    }
}
