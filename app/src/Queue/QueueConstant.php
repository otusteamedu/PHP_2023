<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Queue;

class QueueConstant
{
    public const TYPE_CLIENT_RABBIT = 'rabbit';
    public const QUEUE_NAME = 'msg';
    public const QUEUE_CONSUMER_TAG = 'consumer';
    public const DEFAULT_EXCHANGE_NAME = 'some';
}
