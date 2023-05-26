<?php

declare(strict_types=1);

namespace Vp\App\Application\RabbitMq\Contract;

use Vp\App\Application\Dto\Output\Result;

interface SenderInterface
{
    public function send(string $queueName, string $message): Result;
}
