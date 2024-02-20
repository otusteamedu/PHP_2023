<?php

namespace App\Domains\Order\Application\Requests;

final class CreateOrderRequest
{
    public function __construct(
        public readonly int $shopId,
        public readonly ?string $phone,
        public readonly ?string $email,
        public readonly ?string $deliveryAddress,
        public readonly ?int $tableTentNumber,
        public readonly ?int $employeeId,
    ) {
    }

    public static function createFromArray(array $args): self
    {
        return new self(
            $args['shop_id'],
            $args['phone'] ?? null,
            $args['email'] ?? null,
            $args['delivery_address'] ?? null,
            $args['table_tent_number'] ?? null,
            $args['employee_id'] ?? null,
        );
    }
}
