<?php

declare(strict_types=1);

namespace App\Dto;

final class BookSearchDto
{
    public function __construct(
        public readonly int $size,
        private int $from = 0,
        public readonly ?string $sku = null,
        public readonly ?string $title = null,
        public readonly ?int $minPrice = null,
        public readonly ?int $maxPrice = null,
        /**
         * @var string[]|null
         */
        public readonly ?array $categories = null,
        public readonly ?array $shops = null,
    ) {
    }

    public function getFrom(): int
    {
        return $this->from;
    }

    public function increaseFrom(int $from): void
    {
        $this->from += $from;
    }

    public function setFrom(int $from): void
    {
        $this->from = $from;
    }
}