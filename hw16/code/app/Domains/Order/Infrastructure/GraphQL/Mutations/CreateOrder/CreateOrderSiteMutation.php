<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class CreateOrderSiteMutation extends AbstractCreateOrderMutation
{
    protected $attributes = [
        'name'        => 'create_order_site',
        'description' => 'Создание заявки',
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::string(),
                'description' => "Обязательный. email",
            ],
            'delivery_address' => [
                'type' => Type::string(),
                'description' => "Обязательный. Адрес доставки",
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'delivery_address' => ['required', 'string', 'min:10', 'max:500'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {

    }
}
