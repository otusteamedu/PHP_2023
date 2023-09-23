<?php

declare(strict_types=1);

namespace App\Music\Application\Strategy\SortIteratorStrategy;

interface SortIteratorStrategyInterface
{
    public function sort(array $collection): array;
}
