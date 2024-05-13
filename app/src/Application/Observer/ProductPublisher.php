<?php

declare(strict_types=1);

namespace AYamaliev\Hw16\Application\Observer;

use AYamaliev\Hw16\Domain\Entity\ProductInterface;
use AYamaliev\Hw16\Domain\Observer\PublisherInterface;
use AYamaliev\Hw16\Domain\Observer\SubscriberInterface;

class ProductPublisher implements PublisherInterface
{
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function notify(ProductInterface $product): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($product);
        }
    }
}
