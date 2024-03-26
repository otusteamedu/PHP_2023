<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\QueueMessageBrokers;

use App\Modules\Orders\Domain\Entity\Order;
use App\Modules\Orders\Domain\QueueMessageBrokers\OrderQueueMessageBrokerInterface;
use App\Modules\Orders\Infrastructure\Jobs\SaveOrderInDBJob;
use Illuminate\Support\Facades\Queue;

class OrderRabbitMQMessageBroker implements OrderQueueMessageBrokerInterface
{
    public function add(Order $order): void
    {
        Queue::push(new SaveOrderInDBJob($order));
    }
}
