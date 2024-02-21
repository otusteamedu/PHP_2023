<?php

namespace Shabanov\Otusphp\Builder;

use Shabanov\Otusphp\Decorator\OnionIngradient;
use Shabanov\Otusphp\Decorator\PepperIngradient;
use Shabanov\Otusphp\Decorator\SaladIngradient;
use Shabanov\Otusphp\Interfaces\ProductInterface;

class ProductBuilder
{
    public function __construct(private ProductInterface $product) {}

    public function addOnion(): self
    {
        $this->product = new OnionIngradient($this->product);
        return $this;
    }

    public function addPepper(): self
    {
        $this->product = new PepperIngradient($this->product);
        return $this;
    }

    public function addSalad(): self
    {
        $this->product = new SaladIngradient($this->product);
        return $this;
    }

    public function build(): ProductInterface
    {
        return $this->product;
    }
}
