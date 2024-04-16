<?php

namespace Dmitry\Hw16\Application\Builder;

use Dmitry\Hw16\Application\Decorator\OnionDecorator;
use Dmitry\Hw16\Application\Decorator\PepperDecorator;
use Dmitry\Hw16\Application\Decorator\SaladDecorator;
use Dmitry\Hw16\Domain\Entity\ProductInterface;

class ProductBuilder
{
    private ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $this->product;
    }


    public function addOnion(): self
    {
        $this->product = new OnionDecorator($this->product);
        return $this;
    }

    public function addPepper(): self
    {
        $this->product = new PepperDecorator($this->product);
        return $this;
    }


    public function addSalad(): self
    {
        $this->product = new SaladDecorator($this->product);
        return $this;
    }


    public function build(): ProductInterface
    {
        return $this->product;
    }
}
