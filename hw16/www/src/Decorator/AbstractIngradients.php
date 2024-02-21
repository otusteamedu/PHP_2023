<?php

namespace Shabanov\Otusphp\Decorator;

use Shabanov\Otusphp\Interfaces\ProductInterface;

abstract class AbstractIngradients implements ProductInterface
{
    public function __construct(private readonly ProductInterface $product) {}

    public function getInfo(): string
    {
        return $this->product->getInfo();
    }
}
