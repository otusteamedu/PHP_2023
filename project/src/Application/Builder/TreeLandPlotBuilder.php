<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder;

use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;

class TreeLandPlotBuilder
{
    private array $nodes = [];

    public function addNode(TreeLandPlotInterface $node): void
    {
        $this->nodes[$node->getId()] = $node;
    }

    public function build(): TreeLandPlotInterface
    {
        $adjacencyList = [];
        foreach ($this->nodes as $node) {
            $parentId = $node->getParentId() ?? 0;
            if (array_key_exists($parentId, $adjacencyList)) {
                $parent = $adjacencyList[$parentId];
                $parent->children->addNode($node);
            } else {
                $parent = $this->nodes[$parentId];
                $parent->children->addNode($node);
                $adjacencyList[$parentId] = $parent;
            }
        }

        return $adjacencyList[0];
    }
}
