<?php

namespace App\Domains\Order\Application;

use App\Domains\Order\Application\Factories\Product\AbstractProductFactory;
use App\Domains\Order\Application\Requests\AddProductToOrderRequest;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;

class AddProductToOrderUseCase
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly AbstractProductFactory $productFactory
    ) {
    }

    public function run(AddProductToOrderRequest $request): void
    {
        $order = $this->orderRepository->getById($request->orderId);
        $product = $this->productFactory->make($request);
        $order->addProduct($product);
        $this->orderRepository->saveProductToOrder($order, $product);
    }
}
