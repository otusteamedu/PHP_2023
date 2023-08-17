<?php

declare(strict_types=1);

namespace Root\App\Sandwich;

use Root\App\FactoryInterface;
use Root\App\ProductBuilderAbstract;
use Root\App\StrategyInterface;

class SandwichFactory implements FactoryInterface
{
    public function createBuilder(): ProductBuilderAbstract
    {
        return new SandwichStandartBuilder();
    }

    public function createCookingStrategy(): StrategyInterface
    {
        return new SandwichStrategy();
    }
}
