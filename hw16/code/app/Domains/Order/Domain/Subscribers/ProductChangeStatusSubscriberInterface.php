<?php

namespace App\Domains\Order\Domain\Subscribers;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

interface ProductChangeStatusSubscriberInterface
{
    public function run(AbstractProduct $product): void;
}
