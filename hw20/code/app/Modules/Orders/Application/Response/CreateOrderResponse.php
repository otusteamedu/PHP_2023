<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\Response;

class CreateOrderResponse
{
    public function __construct(
        public string $uid
    )
    {}
}
