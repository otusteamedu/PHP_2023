<?php

namespace App\Domains\Order\Application\Factories\Order;

use App\Domains\Order\Domain\Entity\AbstractOrder;

interface OrderFactoryInterface
{
    public function make(): AbstractOrder;
}
