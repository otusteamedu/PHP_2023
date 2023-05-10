<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PDO;
use Vp\App\Application\Builder\Contract\TreeLandPlotBuilderInterface;
use Vp\App\Application\Contract\TreeDataInterface;
use Vp\App\Application\Dto\Output\ResultTree;
use Vp\App\Application\FactoryBuilder\Contract\LandPlotFactoryBuilderInterface;
use Vp\App\Application\Iterator\TreeLandPlotIterator;
use Vp\App\Application\Message;
use Vp\App\Application\Validator\Contract\ValidatorInterface;
use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;

class TreeData implements TreeDataInterface
{
    private \PDO $conn;
    private LandPlotFactoryBuilderInterface $landPlotFactoryBuilder;
    private TreeLandPlotBuilderInterface $treeLandPlotBuilder;
    private ValidatorInterface $validator;

    public function __construct(
        DatabaseInterface $database,
        LandPlotFactoryBuilderInterface $landPlotFactoryBuilder,
        TreeLandPlotBuilderInterface $treeLandPlotBuilder,
        ValidatorInterface $validator
    ) {
        $this->conn = $database->getConnection();
        $this->landPlotFactoryBuilder = $landPlotFactoryBuilder;
        $this->treeLandPlotBuilder = $treeLandPlotBuilder;
        $this->validator = $validator;
    }

    public function work(): ResultTree
    {
        $result = [];
        $root = $this->createRootNode();
        $tree = new TreeLandPlotIterator($root);

        foreach ($tree as $item) {
            if (!$this->validator->validate($item['name'])) {
                continue;
            }
            $result[] = $item;
        }

        return new ResultTree($result, Message::SUCCESS_CREATE_DATA);
    }

    private function getSql(): string
    {
        return 'SELECT * FROM tree_land_plots';
    }

    private function createRootNode(): TreeLandPlotInterface
    {
        $landPlotFactory = $this->landPlotFactoryBuilder::getInstance();
        $rootNode = $landPlotFactory->createTreeLandPlot('root');
        $this->treeLandPlotBuilder->addNode($rootNode);

        foreach ($this->conn->query($this->getSql(), PDO::FETCH_ASSOC) as $row) {
            $landPlotFactory = $this->landPlotFactoryBuilder::getInstance($row['type']);
            $node = $landPlotFactory->createTreeLandPlot($row['name'], $row['id'], $row['parent_id']);
            $this->treeLandPlotBuilder->addNode($node);
        }

        $root = $this->treeLandPlotBuilder->build();
        return $root;
    }
}
