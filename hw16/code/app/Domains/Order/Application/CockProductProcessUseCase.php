<?php

namespace App\Domains\Order\Application;

use App\Domains\Order\Domain\Publishers\PublisherInterface;
use App\Domains\Order\Domain\Repositories\ProductRepositoryInterface;

class CockProductProcessUseCase
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private PublisherInterface $publisher,
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
