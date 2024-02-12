<?php

declare(strict_types=1);

namespace App\Builder;

class FoodBuilder
{
    private string $name;
    private string $description;
    private float $price;
    private array $ingredients;

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): FoodBuilder
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): FoodBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): FoodBuilder
    {
        $this->price = $price;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): FoodBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function build(): Food
    {
        return new Food($this);
    }
}
