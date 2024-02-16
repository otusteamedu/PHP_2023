<?php

namespace App\Products;

class HotDog implements ProductInterface
{
    protected $name = "Хот-дог";
    protected $price = 3.99;
    protected $ingredients = ['Булка для хот-дога', 'Сосиска', 'Горчица', 'Кетчуп'];

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