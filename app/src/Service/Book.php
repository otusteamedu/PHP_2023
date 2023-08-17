<?php

declare(strict_types=1);

namespace App\Service;

class Book
{
    public function __construct(
        public readonly string $title,
        public readonly string $sku,
        public readonly string $category,
        public readonly int $price,
        public readonly array $stock,
    ) {
    }
}