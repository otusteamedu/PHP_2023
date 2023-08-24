<?php

namespace App\Models;

use App\Models\Products\Product;

class StandardCookingStrategy implements CookingStrategy
{
    public function cook(Product $product)
    {
        echo "Стандартный рецепт: " . $product->getDescription() . "\n";
    }
}
