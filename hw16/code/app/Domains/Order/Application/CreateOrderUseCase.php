<?php

namespace App\Domains\Order\Application;

use App\Domains\Order\Application\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Application\Response\CreateOrderResponse;

class CreateOrderUseCase
{
    public function __construct(
        private readonly OrderFactoryInterface $orderFactory
    )
    {
    }

    public function run(CreateOrderRequest $request): CreateOrderResponse
    {
        $order = $this->orderFactory->make($request);

    }
}
