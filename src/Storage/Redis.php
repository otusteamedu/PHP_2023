<?php

declare(strict_types=1);

namespace Ro\Php2023\Storage;

use Predis\ClientInterface;

class Redis
{
    public function __construct(private readonly ClientInterface $redisClient)
    {
        $this->redisClient->connect();
    }

    public function ping()
    {
        return $this->redisClient->ping();
    }
}
