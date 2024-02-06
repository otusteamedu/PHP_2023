<?php

namespace HW11\Elastic\DI\Decorator;

use HW11\Elastic\DI\Product\Product;

// Декоратор
abstract class ProductDecorator implements Product
{
    protected Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * @return void
     */
    public function prepare(): void
    {
        $this->product->prepare();
    }
}
