<?php

declare(strict_types=1);

namespace App\Infrastructure\Redis\Repository;

use App\Application\Helper\ReadDataHelper;
use App\Domain\QueueElement;
use App\Infrastructure\RepositoryInterface;
use Redis as RedisClient;

class RedisNativeClientRepository implements RepositoryInterface
{
    public RedisClient $client;
    private string $uniqName;

    public function __construct(
        $config
    ) {
        $host = $config->get('REDIS_HOST');
        $port = $config->get('REDIS_PORT');
        $this->uniqName = $config->get('QUEUE_UNIQUE');
        $this->client = new RedisClient(); //
        $this->client->connect($host, (int)$port);
        echo 'Redis native extension connected ...' . PHP_EOL;
    }

    public function init(): void
    {
        $this->addEventsSimple($this->loadEvents());
    }

    private function loadEvents(): array
    {
        return (new ReadDataHelper())->doing();
    }

    private function addEventsSimple(array $events): void
    {
        foreach ($events as $event) {
            $this->addSimple(new QueueElement(
                $event['priority'],
                $event['conditions']['param1'],
                $event['conditions']['param2'],
                $event['event']['name'],
            ));
        }
    }

    private function addSimple(QueueElement $element): void
    {
        $queueName = $this->uniqName . 'simple';
        $decoded = json_encode([
            $element->getPriorityValue(),
            $element->getConditionsParam1Value(),
            $element->getConditionsParam2Value(),
            $element->getEventValue()
        ]);
        $this->client->rpush($queueName, $decoded);
    }

    public function addWithParams(
        string $element,
        int $score,
        int $p1,
        int $p2
    ): void {
        $queueName = $this->uniqName . 'simple';
        $this->client->rpush($queueName, $element);
    }

    public function clearAllEvents(): void
    {
        $queueName = $this->uniqName . 'simple';
        if ($keys = $this->client->keys($queueName)) {
            $this->client->del($keys);
        }
    }

    public function getFirstPrioritized(array $filter): string
    {
        $max = 0;
        $item = '';
        $queueName = $this->uniqName . 'simple';
        while ($element = $this->client->lpop($queueName)) {
            $decoded = json_decode($element, true);
            if (
                ($filter['par1'] === $decoded[1])
                and
                ($filter['par2'] === $decoded[2])
            ) {
                if ($max < $decoded[0]) {
                    $max = $decoded[0];
                    $item = $decoded[3];
                }
            }
        }

        return $item;
    }
}
