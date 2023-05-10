<?php

namespace Vp\App\Application\Builder\Contract;

use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;

interface TreeLandPlotBuilderInterface
{
    public function addNode(TreeLandPlotInterface $node): void;
    public function build(): TreeLandPlotInterface;
}
