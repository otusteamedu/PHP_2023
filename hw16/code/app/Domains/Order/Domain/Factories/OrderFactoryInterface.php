<?php

namespace App\Domains\Order\Domain\Factories;

use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Domain\Entity\Order\AbstractOrder;

/**
 * Абстрактная фабрика пункт 5 из ДЗ
 * 5. Абстрактная фабрика будет генерировать заказы с сайта, из магазина и через телефон.
 */
interface OrderFactoryInterface
{
    public function makeOrder(CreateOrderRequest $request): AbstractOrder;
}
