<?php

declare(strict_types=1);

namespace Root\App;

class RestaurantFastFood extends RestaurantAbstract
{

    protected function cooking(Product $product, StrategyInterface $strategy): void
    {
        $strategy->cooking($product);
    }
}
