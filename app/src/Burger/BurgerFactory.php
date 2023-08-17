<?php

declare(strict_types=1);

namespace Root\App\Burger;

use Root\App\FactoryInterface;
use Root\App\ProductBuilderAbstract;
use Root\App\ProductStrategy;
use Root\App\StrategyInterface;

class BurgerFactory implements FactoryInterface
{
    public function createBuilder(): ProductBuilderAbstract
    {
        return new BurgerStandartBuilder();
    }

    public function createCookingStrategy(): StrategyInterface
    {
        return new BurgerStrategy();
    }
}
