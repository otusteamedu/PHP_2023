<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Application\CreateOrderUseCase;
use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Domain\Factories\OrderFactoryInterface;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

abstract class AbstractCreateOrderMutation extends Mutation
{
    public function __construct(
        protected readonly CreateOrderUseCase $createOrderUseCase,
    ) {
    }

    protected abstract function getOrderFactory(): OrderFactoryInterface;
    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'shop_id' => [
                'type' => Type::int(),
                'description' => 'ID Магазина',
            ],
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'shop_id' => ['required', 'integer'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info): int
    {
        $request = CreateOrderRequest::createFromArray($args);
        $response = $this->createOrderUseCase->run($request, $this->getOrderFactory());
        return $response->orderId;
    }

}
