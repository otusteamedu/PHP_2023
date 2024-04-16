<?php

namespace Dmitry\Hw16\Application\Decorator;

use Dmitry\Hw16\Domain\Entity\ProductInterface;

class OnionDecorator implements ProductInterface
{
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function makeCooked(): void
    {
        $this->product->makeCooked();
    }

    public function getName(): string
    {
        return $this->product->getName() . ' с луком';
    }
}
