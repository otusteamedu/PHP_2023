<?php

namespace Cases\Php2023\Application\Command;

use Predis\Client;

class EventClearCommand extends AbstractCommand
{
    public Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => 'redis',
            'port' => 6379,
        ]);
    }

    public function execute(...$args): string
    {
        return (string) $this->client->executeRaw(['FLUSHDB']);
    }
}