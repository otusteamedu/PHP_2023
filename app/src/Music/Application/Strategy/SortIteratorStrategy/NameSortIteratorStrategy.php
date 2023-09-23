<?php

declare(strict_types=1);

namespace App\Music\Application\Strategy\SortIteratorStrategy;

class NameSortIteratorStrategy implements SortIteratorStrategyInterface
{
    public function sort(array $collection): array
    {
        $keys = array_column($collection, 'name');
        array_multisort($keys, SORT_ASC, $collection);
        return $collection;
    }
}
