<?php

declare(strict_types=1);

namespace Root\App;

abstract class RestaurantAbstract
{
    public function execute(Product $product, StrategyInterface $strategy): void
    {
        $this->payment();
        $this->cooking($product, $strategy);
        $this->assembly();
        $this->delivery();
    }

    protected function payment(): void
    {
        echo 'Payment', PHP_EOL;
    }
    abstract protected function cooking(Product $product, StrategyInterface $strategy): void;
    protected function assembly(): void
    {
        echo 'Assembly', PHP_EOL;
    }
    protected function delivery(): void
    {
        echo 'Delivery', PHP_EOL;
    }
}
