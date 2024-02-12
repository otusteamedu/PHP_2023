<?php

declare(strict_types=1);

namespace App\Proxy;

use App\Builder\FoodInterface;

readonly class FoodProxy implements FoodInterface
{
    public function __construct(private FoodInterface $food)
    {
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
        if ($this->checkIngredients()) {
            return $this->food->toCook();
        }

        return $this->toUtil();
    }

    // Какая-то логика проверки ингредиентов
    private function checkIngredients(): bool
    {
        return !empty($this->getIngredients());
    }

    // Какая-то логика утилизации продукта
    private function toUtil(): string
    {
        return "{$this->food->getName()} to util!";
    }
}
