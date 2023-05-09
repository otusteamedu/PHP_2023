<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PDO;
use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Application\Dto\Output\ResultTree;
use Vp\App\Application\Message;
use Vp\App\Domain\Model\Node;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;

class TreeData implements TreeDataInterface
{
    private \PDO $conn;
    private array $adjacencyList;

    public function __construct(DatabaseInterface $database)
    {
        $this->conn = $database->getConnection();
    }

    public function work(): ResultTree
    {
        $sql = 'SELECT * FROM tree_land_plots';

        $nodes = [];
        $nodes[0] = (new Node(0, null, 'root'))->setLevel(0);

        foreach ($this->conn->query($sql, PDO::FETCH_ASSOC) as $row) {
            $nodes[$row['id']] = new Node($row['id'], $row['number'], $row['name'], $row['parent_id']);
        }

        $this->adjacencyList = [];
        foreach ($nodes as $node) {
            $parentId = $node->getParentId() ?? 0;
            if (array_key_exists($parentId, $this->adjacencyList)) {
                $parent = $this->adjacencyList[$parentId];
                $parent->children->addNode($node);
            } else {
                $parent = $nodes[$parentId];
                $parent->children->addNode($node);
                $this->adjacencyList[$parentId] = $parent;
            }
        }

        $res = $this->dfs($this->adjacencyList[0]);

        return new ResultTree($res, Message::SUCCESS_CREATE_DATA);
    }

    private function dfs($startVertex): array
    {
        $result = [];
        $visited = [];
        $stack[] = $startVertex;

        while (count($stack) !== 0) {
            $startVertex = array_shift($stack);

            if (!in_array($startVertex, $visited, true)) {
                $result[] = $startVertex->getName();
                $visited[] = $startVertex;
            }

            foreach ($startVertex->children as $child) {
                if (!in_array($child, $visited, true)) {
                    array_unshift($stack, $child);
                }
            }
        }

        return $result;
    }
}
