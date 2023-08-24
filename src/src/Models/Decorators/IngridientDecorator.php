<?php

namespace App\Models\Decorators;

use App\Models\Products\Product;

abstract class IngredientDecorator implements Product
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    abstract public function getDescription(): string;
}
