<?php

namespace HW11\Elastic\DI\Strategy;

use HW11\Elastic\DI\Product\Product;

// Стратегия
interface CookingStrategy
{
    public function cook(Product $product): void;
}
