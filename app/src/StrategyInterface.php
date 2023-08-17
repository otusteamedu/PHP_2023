<?php

declare(strict_types=1);

namespace Root\App;

interface StrategyInterface
{
    public function cooking(Product $product): void;
}
