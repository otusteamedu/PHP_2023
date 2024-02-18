<?php

namespace App\Domains\Order\Domain\Repositories;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

interface ProductRepositoryInterface
{
    public function create(AbstractProduct $product): int;

    public function getAvailableAdditionalIngredientsOfProduct(): array;
    public function getDefaultIngredientsOfProduct(): array;

    public function getProductById(): AbstractProduct;
}
