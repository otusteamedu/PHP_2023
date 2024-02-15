<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Application\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Application\Factories\Order\OrderSiteFactory;
use GraphQL\Type\Definition\Type;

class CreateOrderFromSiteMutation extends AbstractCreateOrderMutation
{
    public function args(): array
    {
        return array_merge(parent::args(), [
            'email' => [
                'type' => Type::string(),
                'description' => "Обязательный. email",
            ],
            'delivery_address' => [
                'type' => Type::string(),
                'description' => "Обязательный. Адрес доставки",
            ],
        ]);
    }

    protected function rules(array $args = []): array
    {
        return array_merge(parent::rules(), [
            'email' => ['required', 'string', 'email'],
            'delivery_address' => ['required', 'string', 'min:10', 'max:500'],
        ]);
    }

    protected function getOrderFactory(): OrderFactoryInterface
    {
        return new OrderSiteFactory();
    }
}
