<?php

namespace Dimal\Hw11\Domain\Entity;

use Dimal\Hw11\Domain\ValueObject\Shop;
use Dimal\Hw11\Domain\ValueObject\StockCount;

class StockShopCount
{
    private Shop $shop;
    private StockCount $stockCount;

    public function __construct(Shop $shop, StockCount $stockCount)
    {
        $this->shop = $shop;
        $this->stockCount = $stockCount;
    }

    public function getShop(): Shop
    {
        return $this->shop;
    }

    public function getStockCount(): StockCount
    {
        return $this->stockCount;
    }

}