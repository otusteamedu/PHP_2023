<?php

declare(strict_types=1);

namespace Vp\App\Domain\ModelFactory\Contract;

use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;

interface LandPlotFactoryInterface
{
    public function createTreeLandPlot(string $name, int $id = 0, int $parentId = null): TreeLandPlotInterface;
}
