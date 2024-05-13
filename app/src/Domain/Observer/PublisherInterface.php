<?php

namespace AYamaliev\Hw16\Domain\Observer;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;

    public function notify(ProductInterface $product);
}
