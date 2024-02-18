<?php

namespace App\Domains\Order\Domain\Repositories;

use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

interface OrderRepositoryInterface
{
    public function create(AbstractOrder $order): int;

    public function saveProductToOrder(AbstractOrder $order, AbstractProduct $product): void;

}
