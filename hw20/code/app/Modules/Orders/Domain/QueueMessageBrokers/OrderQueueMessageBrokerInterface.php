<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\QueueMessageBrokers;

use App\Modules\Orders\Domain\Entity\Order;

interface OrderQueueMessageBrokerInterface
{
    public function add(Order $order): void;
}
