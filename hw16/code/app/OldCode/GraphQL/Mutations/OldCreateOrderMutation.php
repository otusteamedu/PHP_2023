<?php

namespace App\OldCode\GraphQL\Mutations;

use App\OldCode\Services\Order\CreateOrderService;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class OldCreateOrderMutation extends Mutation
{
    protected $attributes = [
        'name'        => 'create_order_old',
        'description' => 'Создание заявки старый код',
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
            'title' => [
                'type' => Type::string(),
                'description' => "Обязательный. Заголовок заявки",
            ],
            'description' => [
                'type' => Type::string(),
                'description' => "Обязательный. Описание заявки",
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return CreateOrderService::rules($args);
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $service = new CreateOrderService();
        return $service->run($args);
    }
}
