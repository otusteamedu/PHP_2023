<?php

namespace App\Domains\Order\Application;

use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Application\Response\CreateOrderResponse;
use App\Domains\Order\Domain\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;

class CreateOrderUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    )
    {
    }

    public function run(CreateOrderRequest $request, OrderFactoryInterface $orderFactory): CreateOrderResponse
    {
        $order = $orderFactory->makeOrder($request);
        $orderId = $this->orderRepository->create($order);
        return new CreateOrderResponse($orderId);
    }
}
