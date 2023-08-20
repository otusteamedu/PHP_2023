<?php

declare(strict_types=1);

namespace App\Service;

class Book implements BookInterface
{
    public function __construct(
        private readonly string $title,
        private readonly string $sku,
        private readonly string $category,
        private readonly int $price,
        private readonly array $stock,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStock(): array
    {
        return $this->stock;
    }
}