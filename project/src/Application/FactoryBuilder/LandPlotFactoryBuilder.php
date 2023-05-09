<?php

declare(strict_types=1);

namespace Vp\App\Application\FactoryBuilder;

use Vp\App\Application\FactoryBuilder\Contract\LandPlotFactoryBuilderInterface;
use Vp\App\Domain\ModelFactory\Contract\LandPlotFactoryInterface;
use Vp\App\Domain\ModelFactory\LandPlotFactory;
use Vp\App\Domain\ModelFactory\LandPlotIgsFactory;
use Vp\App\Domain\ModelFactory\LandPlotShFactory;
use Vp\App\Domain\ModelFactory\LandPlotSntFactory;

class LandPlotFactoryBuilder implements LandPlotFactoryBuilderInterface
{
    public static function getInstance(?string $type = null): LandPlotFactoryInterface
    {
        switch ($type) {
            case 'igs':
                return new LandPlotIgsFactory();
            case 'sh':
                return new LandPlotShFactory();
            case 'snt':
                return new LandPlotSntFactory();
            default:
                return new LandPlotFactory();
        }
    }
}
