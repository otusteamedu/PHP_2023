<?php

namespace Cases\Php2023\Application\Command;

use Predis\Client;

class EventGetCommand extends AbstractCommand
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
        $param1 = $args[0];
        $param2 = $args[1];

        $priorities = $this->client->zRevRange('priorities', 0, -1);

        $searchCriteria = json_encode(["param1" => $param1, "param2" => $param2]);
        $foundId = null;
        $foundEvent = null;

        foreach ($priorities as $id) {
            $conditions = $this->client->hGet($id, "conditions");

            if ($conditions == $searchCriteria) {
                $foundId = $id;
                $foundEvent = $this->client->hGet($id, "event");
                break;
            }
        }

        if ($foundId !== null) {
            return "Найден самый приоритетный элемент: $foundId, событие: $foundEvent\n";
        } else {
            return "Элемент с такими условиями не найден\n";
        }
    }
}