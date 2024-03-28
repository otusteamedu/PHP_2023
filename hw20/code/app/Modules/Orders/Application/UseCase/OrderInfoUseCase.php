<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\UseCase;

use App\Modules\Orders\Application\Request\OrderInfoRequest;
use App\Modules\Orders\Application\Response\OrderInfoResponse;
use App\Modules\Orders\Domain\Exception\EntityNotFoundException;
use App\Modules\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Modules\Orders\Domain\ValueObject\UUID;

class OrderInfoUseCase
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {}

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(OrderInfoRequest $request): OrderInfoResponse
    {
        $order = $this->repository->findByUuid(new UUID($request->uuid));
        if (!$order) {
            throw new EntityNotFoundException('Заказ не найден');
        }

        $response = new OrderInfoResponse(
            $order->getUuid()->getValue(),
            $order->getEmail()->getValue(),
            $order->getComment()->getValue(),
        );

        return $response;
    }
}
