<?php

namespace HW11\Elastic\DI\Proxy;

use HW11\Elastic\DI\Product\Product;
//Прокси
class CookingProxy implements Product
{
    private Product $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    public function prepare(): void
    {
        $this->prePrepareEvent();
        $this->product->prepare();
        $this->postPrepareEvent();
    }
    private function prePrepareEvent(): void
    {
        echo "Pre-prepare Event\n";
    }
    private function postPrepareEvent(): void
    {
        echo "Post-prepare Event\n";
    }
    public function getName(): string
    {
        return '';
    }
    public function getPrice(): float
    {
        return 0.0;
    }
}
