<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Decorator;

use Patterns\Daniel\Products\ProductInterface;

abstract class ProductDecorator implements ProductInterface
{
    /**
     * @var ProductInterface
     */
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getPrice(): float
    {
        return $this->product->getPrice();
    }

    public function getIngredients(): array
    {
        return $this->product->getIngredients();
    }
}
