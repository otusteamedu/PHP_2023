<?php

declare(strict_types=1);

namespace App\Modules\Orders\Application\UseCase;

use App\Modules\Orders\Application\Request\OrderDeleteRequest;
use App\Modules\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Modules\Orders\Domain\ValueObject\UUID;

class OrderDeleteUseCase
{
    public function __construct(
        private OrderRepositoryInterface $repository
    )
    {}

    public function __invoke(OrderDeleteRequest $request): void
    {
        $this->repository->deleteByUuid(new UUID($request->uuid));
    }
}
