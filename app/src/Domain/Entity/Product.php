<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Domain\Entity;

use Imitronov\Hw11\Domain\ValueObject\Stock;

final class Product
{
    /**
     * @param Stock[] $stock
     */
    public function __construct(
        private string $sku,
        private string $name,
        private string $category,
        private float $price,
        private array $stock,
    ) {
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return Stock[]
     */
    public function getStock(): array
    {
        return $this->stock;
    }
}
