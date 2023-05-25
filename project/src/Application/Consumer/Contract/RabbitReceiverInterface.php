<?php

declare(strict_types=1);

namespace Vp\App\Application\Consumer\Contract;

use Vp\App\Application\Contract\DataProcessInterface;

interface RabbitReceiverInterface
{
    public function listen(string $queueName, DataProcessInterface $dataProcess, string $method): void;
}
