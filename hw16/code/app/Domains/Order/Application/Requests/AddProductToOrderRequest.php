<?php

namespace App\Domains\Order\Application\Requests;

final class AddProductToOrderRequest
{
    public function __construct(
        public readonly int $orderId,
        public readonly int $productTypeName,
        public readonly array $additionalIngredients = [],

    ) {
    }

    public static function createFromArray(array $args): self
    {
        return new self(
            $args['order_id'],
            $args['product_type_name'] ?? null,
            $args['additional_ingredients'] ?? []
        );
    }
}
