<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Dotenv\Dotenv;
use Predis\Client;

class RedisClient
{
    private Client $client;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $config = [
            'scheme' => $_ENV['REDIS_SCHEME'],
            'host'   => $_ENV['REDIS_HOST'],
            'port'   => (int) $_ENV['REDIS_PORT'],
        ];

        $this->client = new Client($config);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
