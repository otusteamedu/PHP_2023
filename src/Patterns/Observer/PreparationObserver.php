<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Observer;

class PreparationObserver implements ObserverInterface
{
    public function update(string $event, $data = null): void
    {
        switch ($event) {
            case 'order_prepared':
                $this->onOrderPrepared($data);
                break;
            case 'order_started':
                $this->onOrderStarted($data);
                break;
        }
    }

    protected function onOrderStarted($data): void
    {
        echo "Preparation of order {$data['orderId']} has started.\n";
    }

    protected function onOrderPrepared($data): void
    {
        echo "Order {$data['orderId']} is ready.\n";
    }
}
