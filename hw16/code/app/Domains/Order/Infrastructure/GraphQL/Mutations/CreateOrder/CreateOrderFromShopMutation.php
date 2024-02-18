<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Domain\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Domain\Factories\Order\OrderShopFactory;
use GraphQL\Type\Definition\Type;

class CreateOrderFromShopMutation extends AbstractCreateOrderMutation
{
    public function args(): array
    {
        return array_merge(parent::args(), [
            'table_tent_number' => [
                'type' => Type::int(),
                'description' => 'Номер тайбл тенда',
            ],
        ]);
    }

    protected function rules(array $args = []): array
    {
        return array_merge(parent::rules($args), [
            'table_tent_number' => ['nullable', 'number', 'min:1', 'max:99'],
        ]);
    }

    protected function getOrderFactory(): OrderFactoryInterface
    {
        return new OrderShopFactory();
    }
}
