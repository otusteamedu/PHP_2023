<?php

declare(strict_types=1);

namespace src\Infrastructure\Repository;

use Predis\Client;
use src\Application\Repository\RepositoryInterface;
use src\Domain\Event;

class RedisRepository implements RepositoryInterface
{
    private Client $client;
    public function __construct()
    {
        $host = 'redis';
        $port = 6379;
        $connectionParameters = sprintf(
            '%s://%s:%s',
            'tcp',
            $host,
            $port
        );
        $this->client = new Client($connectionParameters);
    }

    public function addNewEvent(Event $event): void
    {
         $values = [
          'priority' => $event->getPriority(),
          'param1' => $event->getConditions()->getParam1(),
          'param2' => $event->getConditions()->getParam2()
        ];
        $this->client->hmset($event->getEvent(), $values);
    }

    public function clearAllEvent(): void
    {
        $this->client->del($this->client->keys('*'));

    }

    public function getByParameters(int $param1, int $param2): Event
    {
        return new Event(
            priority: 100, event: '', conditions: []
        );
    }
}
