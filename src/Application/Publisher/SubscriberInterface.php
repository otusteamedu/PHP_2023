<?php

namespace Dmitry\Hw16\Application\Publisher;

use Dmitry\Hw16\Domain\Entity\Product;

interface SubscriberInterface
{
    public function notify(Product $product, string $status);
}
