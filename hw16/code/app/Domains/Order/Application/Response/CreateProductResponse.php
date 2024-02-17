<?php

namespace App\Domains\Order\Application\Response;

class CreateProductResponse
{
    public function __construct(
        public readonly int $productId
    )
    {
    }
}
