<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp\Application\ValueObject;

use ArrayIterator;
use IteratorAggregate;
use Yalanskiy\SearchApp\Application\Dto\AddBookRequest;

/**
 * AddBookBulkCollection
 */
class AddBookBulkCollection implements IteratorAggregate
{
    private array $data;
    
    public function add(AddBookRequest $data): void
    {
        $this->data[] = $data;
    }
    
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}