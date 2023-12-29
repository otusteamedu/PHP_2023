<?php

declare(strict_types=1);

namespace App\Infrastructure\Redis\Repository;

use App\Application\Helper\ReadDataHelper;
use App\Domain\QueueElement;
use App\Infrastructure\RepositoryInterface;
use Predis\Client as RedisClient;

class PRedisClientRepository implements RepositoryInterface
{
    public RedisClient $client;
    private string $uniqName;

    public function __construct(
        $config
    ) {
        $host = $config->get('REDIS_HOST');
        $port = $config->get('REDIS_PORT');
        $this->uniqName = $config->get('QUEUE_UNIQUE');
        $connectionParameters = sprintf(
            '%s://%s:%s',
            'tcp',
            $host,
            $port
        );
        $this->client = new RedisClient($connectionParameters);
        echo 'PRedis connected ...' . PHP_EOL;
    }

    public function init(): void
    {
        $this->addEventsHash($this->loadEvents());
    }

    private function loadEvents(): array
    {
        return (new ReadDataHelper())->doing();
    }

    private function addEventsHash(array $events): void
    {
        foreach ($events as $event) {
            $this->addHash(new QueueElement(
                $event['priority'],
                $event['conditions']['param1'],
                $event['conditions']['param2'],
                $event['event']['name'],
            ));
        }
    }

    private function addHash(QueueElement $element): void
    {
        $decoded = json_encode([
            $element->getPriorityValue(),
            $element->getConditionsParam1Value(),
            $element->getConditionsParam2Value(),
            $element->getEventValue()
        ]);
        $this->addWithParams(
            $decoded,
            $element->getPriorityValue(),
            $element->getConditionsParam1Value(),
            $element->getConditionsParam2Value()
        );
    }

    public function addWithParams(
        string $element,
        int $score,
        int $p1,
        int $p2
    ): void {
        $name = $this->uniqName . '_hash';
        $queueName = sprintf('%s:%d:%d', $name, $p1, $p2);
        $this->client->zadd($queueName, [$element => $score]);
    }

    public function clearAllEvents(): void
    {
        $name = $this->uniqName . '_hash';
        $queueName = sprintf('%s:%s', $name, '*');
        if ($keys = $this->client->keys($queueName)) {
            $this->client->del($keys);
        }
    }

    public function getFirstPrioritized(array $filter): string
    {
        $name = $this->uniqName . '_hash';
        $queueName = sprintf(
            '%s:%d:%d',
            $name,
            $filter['par1'],
            $filter['par2']
        );
        if ($respond = $this->client->zrange($queueName, -1 , -1)) {
            $item = reset($respond);
            $this->client->zrem($queueName, $item);
            return $item;
        }

        return '';
    }
}
