<?php

declare(strict_types=1);

namespace App\News\Domain\Paginator;

final class NewsIterator implements \Iterator
{
    public function __construct(
        private readonly array $collection,
        private int $position = 0,
    ) {
    }

    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->collection[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
