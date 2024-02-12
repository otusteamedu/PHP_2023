<?php

declare(strict_types=1);

namespace App\Builder;

class Food implements FoodInterface
{
    private string $name;
    private string $description;
    private float $price;
    private array $ingredients;

    public function __construct(FoodBuilder $builder)
    {
        $this->name = $builder->getName();
        $this->description = $builder->getDescription();
        $this->price = $builder->getPrice();
        $this->ingredients = $builder->getIngredients();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function toCook(): string
    {
        return 'cook';
    }
}
