<?php

namespace App\Domains\Order\Application\Factories\Order;

use App\Domains\Order\Domain\Entity\AbstractOrder;
use App\Domains\Order\Domain\Entity\OrderFromPhone;

class OrderPhoneFactory implements OrderFactoryInterface
{
    public function make(): AbstractOrder
    {
        return new OrderFromPhone();
    }
}
