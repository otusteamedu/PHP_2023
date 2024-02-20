<?php

namespace App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder;

use App\Domains\Order\Domain\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Domain\Factories\Order\OrderPhoneCallFactory;
use GraphQL\Type\Definition\Type;

class CreateOrderFromPhoneCallMutation extends AbstractCreateOrderMutation
{
    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return array_merge(parent::args(), [
            'employee_id' => [
                'type' => Type::int(),
                'description' => 'Id сотрудника принимающего звонок',
            ],
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
            'employee_id' => ['required'],
            'phone' => ['required', 'string', 'max:50'],
            'delivery_address' => ['required', 'string', 'min:10', 'max:500'],
        ]);
    }

    protected function getOrderFactory(): OrderFactoryInterface
    {
        return new OrderPhoneCallFactory();
    }
}
