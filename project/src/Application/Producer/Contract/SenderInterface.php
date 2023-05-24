<?php

declare(strict_types=1);

namespace Vp\App\Application\Producer\Contract;

use Vp\App\Application\Dto\Output\ResultSend;

interface SenderInterface
{
    public function send(string $queueName, string $message): ResultSend;
}
