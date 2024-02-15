<?php

namespace App\Domains\Order\Application\Factories\Order;

use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Domain\Entity\Order\AbstractOrder;

interface OrderFactoryInterface
{
    public function makeOrder(CreateOrderRequest $request): AbstractOrder;
}
