<?php

namespace App\Domains\Order\Infrastructure\Repository;

use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Domain\Repository\ProductRepositoryInterface;
use App\Domains\Order\Infrastructure\Models\OrderModel;
use App\Domains\Order\Infrastructure\Models\ProductModel;

class ProductDatabaseRepository implements ProductRepositoryInterface
{
    public function __construct(
        private ProductModel $orderModel,
    )
    {
    }

    public function create(AbstractProduct $product): int
    {
        return 1;
    }
}
