<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\OrderDataInterface;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;

class CommandOrders implements CommandInterface
{
    private OrderDataInterface $orderData;

    public function __construct(OrderDataInterface $orderData)
    {
        $this->orderData = $orderData;
    }

    public function run(): void
    {
        $this->orderData->work();
    }
}
