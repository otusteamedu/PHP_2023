<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\ElasticRequestException;
use App\Model\Event;
use App\Model\EventCondition;
use App\Model\EventData;
use App\Service\ElasticSearchClient;
use DateTimeImmutable;

readonly class ElasticEventRepository implements EventRepositoryInterface
{
    public function __construct(
        private ElasticSearchClient $client,
    ) {
    }

    public function create(Event $event): void
    {
        $body = [];
        $body['priority'] = $event->priority;

        foreach ($event->conditions as $condition) {
            $body['conditions'][] = ['key' => $condition->key, 'value' => $condition->value];
        }


        $body['data'] = [
            'title' => $event->data->title,
            'data' => $event->data->data,
            'createdAt' => $event->data->createdAt->format('Y-m-d\TH:i:s\Z'),
        ];

        $this->client->indexDocument($body);
    }

    public function clear(): void
    {
        $this->client->deleteByQuery([
            'match_all' => new \stdClass(),
        ]);
    }

    /**
     * @param EventCondition[] $conditionsDto
     * @return Event[]
     * @throws ElasticRequestException
     * @throws \Exception
     */
    public function findByConditions(array $conditionsDto): array
    {
        $searchConditions = [];
        foreach ($conditionsDto as $conditionDto) {
            $searchConditions[] = [
                'bool' => [
                    'must' => [
                        [
                            'match' => ['conditions.key' => $conditionDto->key]
                        ],
                        [
                            'match' => ['conditions.value' => $conditionDto->value]
                        ]
                    ]
                ]
            ];
        }
        $response = $this->client->searchByQuery(
            [
                'bool' => [
                    'must' => [
                        [
                            'nested' => [
                                'path' => 'conditions',
                                "query" => [
                                    "bool" => [
                                        "must" => [
                                            [
                                                'bool' => [
                                                    'should' => $searchConditions
                                                ]
                                            ]
                                        ],
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            [
                'analyzer' => [
                    'my_russian' => [
                        "filter" => ["lowercase", "ru_stop", "ru_stemmer"]
                    ]
                ]
            ]
        );

        $events = [];
        foreach ($response['hits']['hits'] as $event) {
            $conditions = [];
            foreach ($event['_source']['conditions'] as $condition) {
                $conditions[] = new EventCondition($condition['key'], $condition['value']);
            }
            $events[] = new Event(
                $event['_source']['priority'],
                $conditions,
                new EventData(
                    $event['_source']['data']['title'],
                    $event['_source']['data']['data'],
                    new DateTimeImmutable($event['_source']['data']['createdAt']),
                )
            );
        }

        return $events;
    }
}
