<?php

declare(strict_types=1);

namespace Vp\App\Application\FactoryBuilder\Contract;

use Vp\App\Domain\ModelFactory\Contract\LandPlotFactoryInterface;

interface LandPlotFactoryBuilderInterface
{
    public static function getInstance(?string $type = null): LandPlotFactoryInterface;
}
