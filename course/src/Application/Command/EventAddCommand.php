<?php

namespace Cases\Php2023\Application\Command;

use Predis\Client;

class EventAddCommand extends AbstractCommand
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
        $itemId = $args[0];
        $priority = (int) $args[1];
        $event = "::" . $args[2] . "::";
        $param1 = $args[3];
        $param2 = $args[4];

        $this->client->zAdd('priorities', [$itemId => $priority]);

        $conditions = json_encode(["param1" => $param1, "param2" => $param2]);
        $this->client->hMSet($itemId, ["conditions" => $conditions, "event" => $event]);
        return 'OK';
    }
}