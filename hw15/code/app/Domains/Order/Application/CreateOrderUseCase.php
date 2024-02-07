<?php

namespace App\Domains\Order\Application;

use App\Domains\Order\Application\Request\CreateOrderRequest;
use App\Domains\Order\Application\Response\CreateOrderResponse;
use App\Domains\Order\Domain\Models\Order;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Domain\ValueObjects\Description;
use App\Domains\Order\Domain\ValueObjects\Email;
use App\Domains\Order\Domain\ValueObjects\Title;
use App\Domains\Order\Infrastructure\Repository\DatabaseOrderRepository;

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
