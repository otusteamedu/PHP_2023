<?php

namespace App\Domains\Order_1\Application\Response;

class CreateOrderResponse
{
    public function __construct(
        public int $id,
    )
    {
    }
}
