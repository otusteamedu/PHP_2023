<?php
declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Queue\Interface;

interface QueueInterface
{
    const QUEUE_NAME_STATEMENT = 'statement';
    const QUEUE_NAME_EMAIL = 'email';
    const QUEUE_NAME_REQUEST = 'request';
}