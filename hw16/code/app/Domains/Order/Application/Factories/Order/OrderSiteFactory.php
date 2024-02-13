<?php

namespace App\Domains\Order\Application\Factories\Order;

use App\Domains\Order\Domain\Entity\AbstractOrder;
use App\Domains\Order\Domain\Entity\OrderFromSite;

class OrderSiteFactory implements OrderFactoryInterface
{
    public function make(): AbstractOrder
    {
        return new OrderFromSite();
    }
}
