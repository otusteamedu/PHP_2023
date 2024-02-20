<?php

namespace App\Domains\Order\Infrastructure\Repository;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Repositories\ProductRepositoryInterface;
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

    public function getAvailableAdditionalIngredientsOfProduct(): array
    {
        // TODO: Implement getAvailableAdditionalIngredientsOfProduct() method.
    }

    public function getDefaultIngredientsOfProduct(): array
    {
        // TODO: Implement getDefaultIngredientsOfProduct() method.
    }

    public function getProductById(): AbstractProduct
    {
        // TODO: Implement getProductById() method.
    }
}
