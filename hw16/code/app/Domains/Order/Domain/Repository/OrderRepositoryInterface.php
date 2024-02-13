<?php

namespace App\Domains\Order\Domain\Repository;

use App\Domains\Order\Domain\Entity\AbstractOrder;

interface OrderRepositoryInterface
{
    public function create(AbstractOrder $order): int;
}
