<?php

namespace IilyukDmitryi\App\Domain\Order;

use Exception;
use IilyukDmitryi\App\Domain\Food\FoodInterface;

interface OrderStrategyInterface
{
    /**
     * @throws Exception
     */
    public function order(FoodInterface $food): void;

}