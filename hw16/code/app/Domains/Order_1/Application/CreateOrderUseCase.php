<?php

namespace App\Domains\Order_1\Application;

use App\Domains\Order_1\Application\Request\CreateOrderRequest;
use App\Domains\Order_1\Application\Response\CreateOrderResponse;
use App\Domains\Order_1\Domain\Models\Order;
use App\Domains\Order_1\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order_1\Domain\ValueObjects\Description;
use App\Domains\Order_1\Domain\ValueObjects\Email;
use App\Domains\Order_1\Domain\ValueObjects\Title;
use App\Domains\Order_1\Infrastructure\Repository\DatabaseOrderRepository;

class CreateOrderUseCase
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {
    }

    public function __invoke(CreateOrderRequest $request): CreateOrderResponse
    {
        $order = new Order(
            new Title($request->title),
            new Description($request->description),
            new Email($request->email),
        );

        $id = $this->repository->create($order);

        return new CreateOrderResponse($id);
    }
}
