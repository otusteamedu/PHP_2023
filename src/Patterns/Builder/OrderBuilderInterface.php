<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Builder;

use Patterns\Daniel\Products\ProductInterface;

interface OrderBuilderInterface
{
    public function addProduct(ProductInterface $product): self;

    public function addIngredient(string $ingredient): self;

    public function getOrder();
}