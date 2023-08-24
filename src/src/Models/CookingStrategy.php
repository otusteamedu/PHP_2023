<?php

namespace App\Models;

use App\Models\Products\Product;

interface CookingStrategy
{
    public function cook(Product $product);
}
