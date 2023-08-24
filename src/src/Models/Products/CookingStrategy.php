<?php

namespace App\Models;

use App\Models\Products\Product;

interface CookingStrategy
{
    public function cook(Product $product);
}

class StandardCookingStrategy implements CookingStrategy
{
    public function cook(Product $product)
    {
        echo "Стандартный рецепт: " . $product->getDescription() . "\n";
    }
}

class CustomCookingStrategy implements CookingStrategy
{
    public function cook(Product $product)
    {
        echo "Пользовательский рецепт: " . $product->getDescription() . "\n";
    }
}
