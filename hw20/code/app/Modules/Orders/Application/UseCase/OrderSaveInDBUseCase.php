<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\UseCase;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\Repository\OrderRepositoryInterface;

class OrderSaveInDBUseCase
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {}

    public function __invoke(Order $order)
    {
        $this->repository->create($order);
    }
}
