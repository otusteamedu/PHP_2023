<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Application\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Application\Factories\Order\OrderPhoneFactory;
use GraphQL\Type\Definition\Type;

class CreateOrderFromPhoneMutation extends AbstractCreateOrderMutation
{
    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return array_merge(parent::args(), [
            'phone' => [
                'type' => Type::string(),
                'description' => 'Номер телефона',
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
            'phone' => ['required', 'string', 'max:50'],
            'delivery_address' => ['required', 'string', 'min:10', 'max:500'],
        ]);
    }

    protected function getOrderFactory(): OrderFactoryInterface
    {
        return new OrderPhoneFactory();
    }
}
