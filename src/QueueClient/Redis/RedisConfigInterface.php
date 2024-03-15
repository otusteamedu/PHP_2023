<?php

declare(strict_types=1);

namespace App\QueueClient\Redis;

interface RedisConfigInterface
{
    public function getHost(): string;

    public function getPort(): int;
}
