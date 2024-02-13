<?php

namespace App\Domains\Order\Application\Factories\Order;

use App\Domains\Order\Domain\Entity\AbstractOrder;
use App\Domains\Order\Domain\Entity\OrderFromShop;

class OrderShopFactory implements OrderFactoryInterface
{
    public function make(): AbstractOrder
    {
        return new OrderFromShop();
    }
}
