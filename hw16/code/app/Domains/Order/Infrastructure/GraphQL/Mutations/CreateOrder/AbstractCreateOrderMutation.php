<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Application\CreateOrderUseCase;
use App\Domains\Order\Application\Factories\Order\OrderFactoryInterface;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

abstract class AbstractCreateOrderMutation extends Mutation
{
    public function __construct(
        protected readonly CreateOrderUseCase $createOrderUseCase,
    )
    {
    }

    protected $attributes = [
        'name'        => 'create_order',
        'description' => 'Создание заказа',
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'shop_id' => [
                'type' => Type::int(),
                'description' => 'ID Магазина'
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'shop_id' => ['required', 'integer']
        ];
    }
}
