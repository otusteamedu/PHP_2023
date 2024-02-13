<?php

namespace App\Domains\Order\Domain\Entity;

class AbstractOrder
{
    protected int $id;
    protected array $products;

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
