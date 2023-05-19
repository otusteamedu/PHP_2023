<?php

namespace Sva\Event\Infrastructure\Repositories;

use Sva\Common\Infrastructure\ElasticConnection;
use Sva\Event\Domain\Event;

class Elastic implements \Sva\Event\Domain\EventRepositoryInterface
{
    private ElasticConnection $connection;

    public function __construct()
    {
        $this->connection = ElasticConnection::getInstance();
        $this->createIndexIfNotExists();
    }

    /**
     * @param array $arParams
     * @return array
     */
    public function getList(array $arParams = []): array
    {
        $arResult = [];
        $filter = [];

        if (!empty($arParams)) {
            foreach ($arParams as $paramName => $value) {
                $filter[] = ['match' => ['conditions.' . $paramName => $value]];
            }
        }

        $p = [
            'index' => 'events',
            'body' => [
                'query' => [
                    'nested' => [
                        'path' => 'conditions',
                        'query' => [
                            'bool' => [
                                'filter' => $filter
                            ]
                        ]
                    ]
                ]
            ]
        ];


        try {
            $r = $this->connection->getConnection()->search($p);

            foreach ($r->asArray()['hits']['hits'] as $event) {
                $event = new Event($event['_source']['priority'], $event['_source']['conditions'], $event['_source']['event']);
                $arResult[] = $event;
            }
        } catch (\Exception) {
        }

        return $arResult;
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function add(Event $event): bool
    {
        $nextId = $this->getNextEventKey();
        try {
            $this->connection->getConnection()->create([
                'index' => 'events',
                'id' => $nextId,
                'body' => [
                    'priority' => $event->getPriority(),
                    'conditions' => $event->getConditions(),
                    'event' => $event->getEvent(),
                ]
            ]);
        } catch (\Exception) {
            return false;
        }

        return true;
    }

    /**
     * @return int
     */
    private function getNextEventKey(): int
    {
        try {
            $cnt = $this->connection->getConnection()->count([
                'index' => 'events'
            ]);
        } catch (\Exception) {
            $cnt = ['count' => 0];
        }

        return $cnt['count'] + 1;
    }

    private function createIndexIfNotExists(): bool
    {
        try {
            $r = $this->connection->getConnection()->indices()->get(['index' => 'events']);
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                return $this->createIndex();
            }
        }

        return true;
    }

    private function createIndex(): bool
    {
        $r = $this->connection->getConnection()->indices()->create([
            'index' => 'events',
            'body' => [
                'mappings' => [
                    'properties' => [
                        'priority' => [
                            'type' => 'integer'
                        ],
                        'conditions' => [
                            "type" => "nested"
                        ],
                        'event' => [
                            'type' => 'text'
                        ]
                    ]
                ]
            ]
        ]);

        return $r->getStatusCode() == 200;
    }

    public function deleteIndex(): bool
    {
        $r = $this->connection->getConnection()->indices()->delete(['index' => 'events']);
        return $r->getStatusCode() == 200;
    }

    public function clear(): void
    {
        try {
            $this->deleteIndex();
            $this->createIndex();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
