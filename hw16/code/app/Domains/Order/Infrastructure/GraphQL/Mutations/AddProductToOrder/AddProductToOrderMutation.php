<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\AddProductToOrder;

use App\Domains\Order\Application\AddProductToOrderUseCase;
use App\Domains\Order\Application\Requests\AddProductToOrderRequest;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

abstract class AddProductToOrderMutation extends Mutation
{
    public function __construct(
        protected readonly AddProductToOrderUseCase $addProductToOrderUseCase,
    ) {
    }

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'order_id' => [
                'type' => Type::int(),
                'description' => 'ID Заказа',
            ],
            'product_type_name' => [
                'type' => Type::string(),
                'description' => 'Название продукта',
            ],
            'additional_ingredients' => [
                'type' => ListOfType::string(),
                'description' => 'Дополнительный список ингридиетов к продукту'
            ]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'order_id' => ['required', 'integer'],
            'product_type_name' => ['required', 'string', 'min:3', 'max:100'],
            'additional_ingredients' => ['nullable']
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info): void
    {
        $request = AddProductToOrderRequest::createFromArray($args);
        $this->addProductToOrderUseCase->run($request);
    }
}
