<?php

declare(strict_types=1);

namespace App\Infrastructure\MongoDB\Repository;

use App\Application\Helper\ReadDataHelper;
use App\Infrastructure\RepositoryInterface;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Manager as MongoClient;
use MongoDB\Driver\Query;

class MongoNativeClientRepository implements RepositoryInterface
{
    public MongoClient $client;
    private string $uniqueName;

    private const FIELD1_PRIORITY = 'priority';
    private const FIELD2_PARAM1 = 'conditions_param1';
    private const FIELD3_PARAM2 = 'conditions_param2';
    private const FIELD4_EVENT = 'event_name';

    public function __construct(
        $config
    ) {
        $host = $config->get('MONGO_HOST');
        $port = $config->get('MONGO_PORT');
        $scheme = 'mongodb';
        $connectionParameters = sprintf(
            '%s://%s:%s',
            $scheme,
            $host,
            $port
        );
        $this->client = new MongoClient($connectionParameters);
        $this->uniqueName = $config->get('QUEUE_UNIQUE');
        echo 'MongoDB connected ...' . PHP_EOL;
    }

    public function init(): void
    {
        $this->addEvents($this->loadEvents());
    }

    private function loadEvents(): array
    {
        return (new ReadDataHelper())->doing();
    }

    private function addEvents(array $events): void
    {
        $mongoBulkWrite = new BulkWrite();
        foreach ($events as $event) {
            $mongoBulkWrite->insert([
                $this::FIELD1_PRIORITY => $event['priority'],
                $this::FIELD2_PARAM1 => $event['conditions']['param1'],
                $this::FIELD3_PARAM2 => $event['conditions']['param2'],
                $this::FIELD4_EVENT => $event['event']['name'],
            ]);
        }

        $this->client->executeBulkWrite(
            $this->getNamespace(),
            $mongoBulkWrite
        );
    }

    public function addWithParams(
        string $element,
        int $score,
        int $p1,
        int $p2
    ): void {
        $mongoBulkWrite = new BulkWrite();
        $mongoBulkWrite->insert([
            $this::FIELD1_PRIORITY => $score,
            $this::FIELD2_PARAM1 => $p1,
            $this::FIELD3_PARAM2 => $p2,
            $this::FIELD4_EVENT => $element,
        ]);
        $this->client->executeBulkWrite($this->getNamespace(), $mongoBulkWrite);
    }

    public function clearAllEvents(): void
    {
        $this->deleteByFilter([]);
    }

    private function deleteByFilter(array $filter): void
    {
        $mongoBulkWrite = new BulkWrite();
        $mongoBulkWrite->delete($filter);
        $this->client->executeBulkWrite($this->getNamespace(), $mongoBulkWrite);
    }

    public function getFirstPrioritized(array $filter): string
    {
        $query = new Query(
            [
                $this::FIELD2_PARAM1 => $filter['par1'],
                $this::FIELD3_PARAM2 => $filter['par2']
            ],
            ['sort' => [$this::FIELD1_PRIORITY => -1], 'limit' => 1]
        );
        $rows = $this->client->executeQuery($this->getNamespace(), $query);
        foreach ($rows as $item) {
            $this->deleteByFilter(['_id' => $item->_id]);
            return $item->event_name;
        }

        return '';
    }

    private function getNamespace(): string
    {
        return sprintf('%s.%s', $this->uniqueName, 'event');
    }
}
