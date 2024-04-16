<?php

namespace Dmitry\Hw16\Application\Publisher;

use Dmitry\Hw16\Domain\Entity\Product;
use MongoDB\Driver\Monitoring\Subscriber;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;

    public function unsubscribe(SubscriberInterface $subscriber): void;

    public function notify(Product $product, string $status);
}
