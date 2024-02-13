<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;
use App\Domains\Order\Application\Factories\Order\OrderPhoneFactory;
use App\Domains\Order\Application\Factories\Order\OrderShopFactory;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class CreateOrderShopMutation extends AbstractCreateOrderMutation
{
    protected $attributes = [
        'name'        => 'create_order_shop',
        'description' => 'Создание заявки из магазина',
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return array_merge(parent::args(), [
            'table_tent_number' => [
                'type' => Type::int(),
                'description' => 'Номер тайбл тенда'
            ],
        ]);
    }

    protected function rules(array $args = []): array
    {
        return array_merge( parent::rules($args), [
            'table_tent_number' => ['nullable', 'number', 'min:1', 'max:99']
        ]);
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $orderFactory = new OrderShopFactory();
    }
}
