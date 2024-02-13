<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Application\Requests\CreateOrderRequest;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class CreateOrderPhoneMutation extends AbstractCreateOrderMutation
{
    protected $attributes = [
        'name'        => 'create_order_phone',
        'description' => 'Создание заказа через телефон',
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return array_merge(parent::args(), [
            'phone' => [
                'type' => Type::string(),
                'description' => 'Номер телефона'
            ],
        ]);
    }

    protected function rules(array $args = []): array
    {
        return array_merge(parent::args(), [
            'phone' => ['required', 'string', 'max:50'],
        ]);
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $request = CreateOrderRequest::createFromArray($args);
        $response = $this->createOrderUseCase->run($request);
        return $response->orderId;
    }
}
