<?php

namespace Shabanov\Otusphp\Decorator;

use Shabanov\Otusphp\Interfaces\ProductInterface;

class MultipleIngradients extends AbstractIngradients
{
    public function __construct(private ProductInterface $product,
                                private array $ingradients
    ) {
        foreach ($this->ingradients as $ingradient) {
            $this->product = new $ingradient($this->product);
        }
    }

    public function getInfo(): string
    {
        return $this->product->getInfo();
    }
}
