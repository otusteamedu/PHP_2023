<?php

declare(strict_types=1);

namespace Root\App;

interface FactoryInterface
{
    public function createBuilder(): ProductBuilderAbstract;
    public function createCookingStrategy(): StrategyInterface;
}
