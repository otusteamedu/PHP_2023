<?php

namespace Cases\Php2023\Domain\Pattern\Iterator;

use Iterator;

class IngredientsIterator implements Iterator
{
    private array $ingredients;
    private int $index = 0;

    public function __construct(array $ingredients)
    {
        $this->ingredients = array_values($ingredients);
    }

    public function current()
    {
        return $this->ingredients[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->ingredients[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}