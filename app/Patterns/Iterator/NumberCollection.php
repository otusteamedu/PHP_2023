<?php
declare(strict_types=1);

namespace Iterator;

use Iterator;
use IteratorAggregate;

class NumberCollection implements IteratorAggregate
{
    private $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(int $item)
    {
        $this->items[] = $item;
    }

    public function getIterator(): Iterator
    {
        return new NumberSquaredIterator($this);
    }
}
