<?php

namespace AYamaliev\Hw16\Domain\Observer;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;

interface SubscriberInterface
{
    public function update(ProductInterface $product): void;
}
