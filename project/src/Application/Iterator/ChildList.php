<?php

declare(strict_types=1);

namespace Vp\App\Application\Iterator;

use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;

class ChildList implements \Iterator
{

    private array $nodes = [];
    private int $currentIndex = 0;

    public function addNode(TreeLandPlotInterface $node): void
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
