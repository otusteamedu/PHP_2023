<?php

namespace App\Domains\Order\Domain\Publishers;

use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Subscribers\ProductChangeStatusSubscriberInterface;

class Publisher implements PublisherInterface
{
    /**
     * @var ProductChangeStatusSubscriberInterface[]
     */
    private array $subscribers = [];

    public function subscribe(ProductChangeStatusSubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function notify(AbstractProduct $product): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->run($product);
        }
    }
}
