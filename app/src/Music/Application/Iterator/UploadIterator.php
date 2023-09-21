<?php

declare(strict_types=1);

namespace App\Music\Application\Iterator;

class UploadIterator implements UploadIteratorInterface
{
    private array $collection;
    private int $currentElement = 0;

    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }

    public function getNext()
    {
        $current = $this->collection[$this->currentElement];
        $this->currentElement++;
        return $current;
    }

    public function hasMore(): bool
    {
        if (isset($this->collection[$this->currentElement])) {
            return true;
        }
        return false;
    }
}
