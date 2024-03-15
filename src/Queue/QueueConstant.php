<?php

declare(strict_types=1);

namespace App\Queue;

class QueueConstant
{
    public const QUEUE_NAME = 'otus-queue';
    public const EXCHANGE_NAME = 'otus-exchange';

    public const QUEUE_TYPE_RABBIT = 'rabbitMQ';
    public const QUEUE_TYPE_REDIS = 'redis';
}
