<?php

declare(strict_types=1);

namespace App\Service;

final class SearchResult
{
    /**
     * @param BookInterface[] $books
     * @param int $total
     */
    public function __construct(
        public readonly array $books,
        public readonly int $total,
    ) {
    }
}