<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Repository;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\ValueObject\UUID;

interface OrderRepositoryInterface
{
    public function create(Order $order): void;
    public function update(Order $order): void;

    public function getList(): array;

    public function findByUuid(UUID $uuid): ?Order;

    public function deleteByUuid(UUID $uuid): void;
}
