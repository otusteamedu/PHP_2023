<?php

declare(strict_types=1);

namespace App;

use Predis\Client;

class RedisClient
{
    private $client;

    public function __construct(array $config)
    {
        $this->client = new Client($config);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
