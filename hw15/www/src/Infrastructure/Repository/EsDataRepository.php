<?php

namespace Shabanov\Otusphp\Infrastructure\Repository;

use Elastic\Elasticsearch\Client;
use Shabanov\Otusphp\Domain\Repository\DataRepositoryInterface;
use Shabanov\Otusphp\Infrastructure\Db\ConnectionInterface;

class EsDataRepository implements DataRepositoryInterface
{
    private Client $connection;
    private string $esIndexName;
    private array $arRequest;

    /**
     * @throws \Exception
     */
    public function __construct(ConnectionInterface $connection, array $arRequest, string $dbName)
    {
        $this->connection = $connection->getClient();
        $this->arRequest = $arRequest;
        $this->esIndexName = $dbName;
    }

    public function getData(): ?array
    {
        $response = $this->connection->search($this->getQuery());
        if ($response['hits']['total']['value'] > 0) {
            return $response['hits']['hits'];
        }
        return null;
    }

    private function getQuery(): array
    {
        $arReturn = [
            'index' => $this->esIndexName,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                    ]
                ],
            ],
        ];

        if (!empty($this->arRequest['c'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'match' => [
                    'category' => [
                        'query' => $this->arRequest['c'],
                        'fuzziness' => 'auto',
                    ]
                ],
            ];
        }
        if (!empty($this->arRequest['t'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $this->arRequest['t'],
                        'fuzziness' => 'auto',
                    ],
                ],
            ];
        }
        if (!empty($this->arRequest['p'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'range' => [
                    'price' => [
                        'lte' => $this->arRequest['p'],
                    ],
                ],
            ];
        }

        $arReturn['body']['query']['bool']['must'][] = [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'range' => [
                        'stock.stock' => [
                            'gte' => 16,
                        ],
                    ],
                ]
            ],
        ];
        return $arReturn;
    }
}
