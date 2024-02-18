<?php

namespace App\Domains\Order\Domain\Events;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;

class ProductChangeStatusEvent
{
    public function __construct(AbstractProduct $product)
    {
    }
}
