<?php

declare(strict_types=1);

namespace Vp\App\Application\Iterator;

use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;

class TreeLandPlotIterator implements \Iterator
{
    private array $tree;
    private int $currentIndex = 0;

    public function __construct(TreeLandPlotInterface $treeLandPlot)
    {
        $this->tree = $this->dfs($treeLandPlot);
    }
    private function dfs($startVertex): array
    {
        $result = [];
        $visited = [];
        $stack[] = $startVertex;

        while (count($stack) !== 0) {
            $startVertex = array_shift($stack);

            if (!in_array($startVertex, $visited, true)) {
                $result[] = $this->getItem($startVertex);
                $visited[] = $startVertex;
            }

            foreach ($startVertex->children as $child) {
                $currentLevel = $startVertex->getLevel();
                $child->setLevel(++$currentLevel);
                if (!in_array($child, $visited, true)) {
                    array_unshift($stack, $child);
                }
            }
        }

        return $result;
    }

    public function current(): mixed
    {
        return $this->tree[$this->currentIndex];
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
        return isset($this->tree[$this->currentIndex]);
    }

    public function rewind(): void
    {
        $this->currentIndex = 0;
    }

    private function getItem(TreeLandPlotInterface $startVertex): array
    {
        $item['name'] = $startVertex->getName();
        $item['level'] = $startVertex->getLevel();
        return $item;
    }
}
