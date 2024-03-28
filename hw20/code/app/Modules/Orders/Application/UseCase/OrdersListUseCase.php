<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\UseCase;

use App\Modules\Orders\Infrastructure\Repository\OrderDBRepository;

class OrdersListUseCase
{
    public function __construct(
        private OrderDBRepository $repository
    )
    {}

    public function __invoke()
    {
        $orders = $this->repository->getList();
        return $orders;
    }
}
