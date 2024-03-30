<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\UseCase;

use App\Modules\Orders\Application\Request\OrderUpdateRequest;
use App\Modules\Orders\Domain\Exception\EntityNotFoundException;
use App\Modules\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Modules\Orders\Domain\ValueObject\Comment;
use App\Modules\Orders\Domain\ValueObject\Email;
use App\Modules\Orders\Domain\ValueObject\UUID;

class OrderUpdateUseCase
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {}

    /**
     * @throws EntityNotFoundException
     */
    public function __invoke(OrderUpdateRequest $request): void
    {
        $order = $this->repository->findByUuid(new UUID($request->uuid));
        if (!$order) {
            throw new EntityNotFoundException('Заказ не найден');
        }

        $order->setEmail(new Email($request->email));
        $order->setComment(new Comment($request->comment));
        $this->repository->update($order);
    }
}
