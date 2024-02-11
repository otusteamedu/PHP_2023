<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\UseCase\Request\CreateOrderRequest;
use src\Domain\Builder\OrderBuilder;
use src\Domain\Entity\Order;

class CrateOrderUseCase
{
    public function __construct(private OrderBuilder $orderBuilder){}

    public function __invoke(CreateOrderRequest $request): Order
    {
        //проверяем адрес на валидность
        $this->orderBuilder->setAddress($request->getAddress());

        //проверяем телефон на валидность
        $this->orderBuilder->setPhone($request->getPhone());

        //проверяем email на валидность
        $this->orderBuilder->setEmail($request->getEmail());

        return $this->orderBuilder->build();
    }
}
