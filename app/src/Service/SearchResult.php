<?php

declare(strict_types=1);

namespace App\Service;

final class SearchResult
{
    public function __construct(
        /** @var Book[] */
        public readonly array $books,
        public readonly int $total,
    ) {
    }
}