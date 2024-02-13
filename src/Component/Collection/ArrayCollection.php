<?php
declare(strict_types=1);

namespace WorkingCode\Hw13\Component\Collection;

class ArrayCollection
{
    private array $elements = [];

    public function add(mixed $element): void
    {
        $this->elements[] = $element;
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function count(): int
    {
        return count($this->elements);
    }
}
