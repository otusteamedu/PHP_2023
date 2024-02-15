<?php

namespace App\Domains\Order\Domain\Repository;

use App\Domains\Order\Domain\Entity\Product\Product;

interface ProductRepositoryInterface
{
    public function create(Product $order): int;
}
