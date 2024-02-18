<?php

namespace App\Domains\Order\Domain\Publishers;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Subscribers\ProductChangeStatusSubscriberInterface;

interface PublisherInterface
{
    public function subscribe(ProductChangeStatusSubscriberInterface $subscriber): void;

    public function notify(AbstractProduct $product): void;
}
