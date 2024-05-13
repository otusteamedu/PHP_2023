<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\Decorator;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;

class OnionDecorator implements ProductInterface
{
    public function __construct(
        private ProductInterface $product,
        private float $additionalPrice,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->product->getTitle() . ' c луком';
    }

    public function getPrice(): float
    {
        return $this->product->getPrice() + $this->additionalPrice;
    }

    public function cook(): void
    {
        $this->product->cook();
    }
}
