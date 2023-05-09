<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

class NodeList implements \Iterator
{

    private array $nodes = [];
    private int $currentIndex = 0;

    public function addNode(Node $node): void
    {
        array_unshift($this->nodes, $node);
    }
    public function current(): mixed
    {
        return $this->nodes[$this->currentIndex];
    }

    public function next(): void
    {
        $this->currentIndex++;
    }

    public function key(): mixed
    {
        return $this->currentIndex;
    }

    public function valid(): bool
    {
        return isset($this->nodes[$this->currentIndex]);
    }

    public function rewind(): void
    {
        $this->currentIndex = 0;
    }
}
