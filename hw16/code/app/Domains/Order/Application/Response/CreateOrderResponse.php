<?php

namespace App\Domains\Order\Application\Response;

class CreateOrderResponse
{
    public function __construct(
        public readonly int $orderId
    )
    {
    }
}
