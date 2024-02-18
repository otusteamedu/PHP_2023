<?php

namespace App\Domains\Order\Application;

use App\Domains\Order\Domain\Publishers\PublisherProductChangeStatusInterface;
use App\Domains\Order\Domain\Repositories\ProductRepositoryInterface;

class CockProductProcessUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private PublisherProductChangeStatusInterface $publisher,
    )
    {
    }

    public function run(): void
    {
        $product = $this->productRepository->getProductById();
        $product->cock();
        $this->publisher->notify($product);
    }
}
