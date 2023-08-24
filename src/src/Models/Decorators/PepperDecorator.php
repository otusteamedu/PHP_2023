<?php

namespace App\Models\Decorators;

use App\Models\Products\Product;

class PepperDecorator extends IngredientDecorator
{
    public function getDescription(): string
    {
        return $this->product->getDescription() . ", перец";
    }
}
