<?php
declare(strict_types=1);

namespace Iterator;

use Iterator;
use ReturnTypeWillChange;

class NumberSquaredIterator implements Iterator
{

    private NumberCollection $collection;

    private int $position = 0;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    #[ReturnTypeWillChange]
    public function rewind()
    {
        $this->position = 0;
    }

    #[ReturnTypeWillChange]
    public function current()
    {
        return $this->collection->getItems()[$this->position] ** 2;
    }

    #[ReturnTypeWillChange]
    public function key()
    {
        return $this->position;
    }

    #[ReturnTypeWillChange]
    public function next()
    {
        $this->position = $this->position + 1;
    }

    #[ReturnTypeWillChange]
    public function valid()
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}
