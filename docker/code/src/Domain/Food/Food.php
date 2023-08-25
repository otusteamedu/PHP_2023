<?php

namespace IilyukDmitryi\App\Domain\Food;

class Food implements FoodInterface
{

    protected string $name;
    protected array $ingredients = [];
    protected int $price = 0;

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $arrIngredients): self
    {
        $this->ingredients = $arrIngredients;
        return $this;
    }

    public function getNameFood(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setNameFood(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFormatName(): string
    {
        return $this->name . " (" . implode(',', $this->ingredients) . ")";
    }
}
