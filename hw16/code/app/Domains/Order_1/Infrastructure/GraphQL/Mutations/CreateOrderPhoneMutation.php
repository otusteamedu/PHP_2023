<?php

namespace App\Domains\Order_1\Infrastructure\GraphQL\Mutations;

use App\Domains\Order\Application\CreateOrderUseCase;
use App\Domains\Order\Application\Request\CreateOrderRequest;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class CreateOrderPhoneMutation extends Mutation
{
    public function __construct(
        private CreateOrderUseCase $createOrderUseCase
    )
    {
    }

    protected $attributes = [
        'name'        => 'create_order',
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
        return [
            'email' => ['required', 'string', 'email'],
            'title' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $request = CreateOrderRequest::fromArray($args);
        $response = ($this->createOrderUseCase)($request);
        return $response->id;
    }
}
