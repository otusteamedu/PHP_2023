<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\Decorator;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;

class SaladDecorator implements ProductInterface
{
    public function __construct(
        private ProductInterface $product,
        private float $additionalPrice,
    )
    {
    }

    public function getTitle(): string
    {
        return $this->product->getTitle() . ' с салатом';
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
