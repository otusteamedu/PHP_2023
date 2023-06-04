<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Dto\Output\ResultQueue;
use Vp\App\Application\RabbitMq\Contract\SenderInterface;

class Queue
{
    private SenderInterface $sender;

    public function __construct(SenderInterface $sender)
    {
        $this->sender = $sender;
    }

    public function createJob(string $queueName, string $message): ResultQueue
    {
        return $this->sender->send($queueName, $message);
    }
}
