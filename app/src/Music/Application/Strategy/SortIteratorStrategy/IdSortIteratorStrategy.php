<?php

declare(strict_types=1);

namespace App\Music\Application\Strategy\SortIteratorStrategy;

class IdSortIteratorStrategy implements SortIteratorStrategyInterface
{

    public function sort(array $collection): array
    {
        $keys = array_column($collection, 'id');
        array_multisort($keys, SORT_DESC, $collection);
        return $collection;
    }
}