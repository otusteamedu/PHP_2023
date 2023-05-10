<?php

declare(strict_types=1);

namespace Vp\App\Domain\ModelFactory;

use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;
use Vp\App\Domain\Model\TreeLandPlot;
use Vp\App\Domain\ModelFactory\Contract\LandPlotFactoryInterface;

class LandPlotFactory implements LandPlotFactoryInterface
{
    public function createTreeLandPlot(string $name, int $id = 0, int $parentId = null): TreeLandPlotInterface
    {
        return new TreeLandPlot($name, $id, $parentId);
    }
}
