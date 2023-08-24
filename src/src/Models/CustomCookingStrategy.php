<?php

namespace App\Models;

use App\Models\Products\Product;

class CustomCookingStrategy implements CookingStrategy
{
    public function cook(Product $product)
    {
        echo "Пользовательский рецепт: " . $product->getDescription() . "\n";
    }
}
