<?php

namespace App\Models\Decorators;

use App\Models\Products\Product;

class SaladDecorator extends IngredientDecorator
{
    public function getDescription(): string
    {
        return $this->product->getDescription() . ", салат";
    }
}
