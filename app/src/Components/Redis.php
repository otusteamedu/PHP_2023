<?php

namespace App\Components;

use Predis\Client;

class Redis
{
    private Client $client;

    public function __construct(string $schema, string $host, string $port)
    {
        $this->client = new Client([
            'schema' => $schema,
            'host' => $host,
            'port' => $port,
        ]);
    }

    public function get(string $key): ?string
    {
        return $this->client->get($key);
    }

    public function set(string $key, $value): void
    {
        $this->client->set($key, $value);
    }
}
