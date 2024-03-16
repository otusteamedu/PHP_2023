<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Domain\Entity;

use ArrayIterator;
use IteratorAggregate;

/**
 * BookCollection
 */
class BookCollection implements IteratorAggregate {
    private array $data;
    
    public function add(Book $data): void
    {
        $this->data[] = $data;
    }
    
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}