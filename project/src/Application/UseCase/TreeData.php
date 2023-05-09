<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PDO;
use Vp\App\Application\Builder\TreeLandPlotBuilder;
use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Application\Dto\Output\ResultTree;
use Vp\App\Application\FactoryBuilder\LandPlotFactoryBuilder;
use Vp\App\Application\Iterator\TreeLandPlotIterator;
use Vp\App\Application\Message;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;

class TreeData implements TreeDataInterface
{
    private \PDO $conn;

    public function __construct(DatabaseInterface $database)
    {
        $this->conn = $database->getConnection();
    }

    public function work(): ResultTree
    {
        $landPlotFactory = LandPlotFactoryBuilder::getInstance();
        $treeLandPlotBuilder = new TreeLandPlotBuilder();

        $rootNode = $landPlotFactory->createTreeLandPlot('root');
        $treeLandPlotBuilder->addNode($rootNode);

        $sql = 'SELECT * FROM tree_land_plots';

        foreach ($this->conn->query($sql, PDO::FETCH_ASSOC) as $row) {
            $landPlotFactory = LandPlotFactoryBuilder::getInstance($row['type']);
            $node = $landPlotFactory->createTreeLandPlot($row['name'], $row['id'], $row['parent_id']);
            $treeLandPlotBuilder->addNode($node);
        }

        $root = $treeLandPlotBuilder->build();
        $tree = new TreeLandPlotIterator($root);

        return new ResultTree($tree, Message::SUCCESS_CREATE_DATA);
    }
}
