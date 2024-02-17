<?php

namespace App\Domains\Order\Application\Requests;

final class AddIngredientsToProductRequest
{
    public function __construct(
        public readonly int $productId,
    ) {
    }

    public static function createFromArray(array $args): self
    {
        return new self(
            $args['product_id'] ?? null,
        );
    }
}
