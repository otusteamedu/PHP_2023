<?php

namespace App\Domains\Order\Domain\Notifications\ProductChangeStatusNotifications;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

abstract class ProductChangeStatusNotificationHandler
{
    public function __construct(
        private ?ProductChangeStatusNotificationHandler $productStatusNotificationHandler = null
    )
    {
    }

    public function setNext(ProductChangeStatusNotificationHandler $productStatusNotificationHandler): ProductChangeStatusNotificationHandler
    {
        $this->productStatusNotificationHandler = $productStatusNotificationHandler;
        return $productStatusNotificationHandler;
    }

    public function handle(AbstractProduct $product): void
    {
        $this->productStatusNotificationHandler?->handle($product);
    }
}
