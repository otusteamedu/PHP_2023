<?php

namespace Shabanov\Otusphp\Infrastructure\Repository;

use Elastic\Elasticsearch\Client;
use Shabanov\Otusphp\Application\Dto\DataHandlerResponse;
use Shabanov\Otusphp\Domain\Repository\DataRepositoryInterface;
use Shabanov\Otusphp\Infrastructure\Db\ConnectionInterface;

class EsDataRepository implements DataRepositoryInterface
{
    private Client $connection;
    private string $esIndexName;

    /**
     * @throws \Exception
     */
    public function __construct(ConnectionInterface $connection, string $dbName)
    {
        $this->connection = $connection->getClient();
        $this->esIndexName = $dbName;
    }

    public function findAll(array $arRequest): ?array
    {
        $response = $this->connection->search($this->getQuery($arRequest));
        if ($response['hits']['total']['value'] > 0) {
            $result = [];
            foreach($response['hits']['hits'] as $item) {
                $result[] = new DataHandlerResponse(
                    $item['_source']['sku'],
                    $item['_source']['title'],
                    $item['_source']['category'],
                    $item['_source']['price'],
                    $item['_source']['shop'],
                    $item['_source']['stock'],
                );
            }
            return $result;
        }
        return null;
    }

    private function getQuery(array $arRequest): array
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

        if (!empty($arRequest['c'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'match' => [
                    'category' => [
                        'query' => $arRequest['c'],
                        'fuzziness' => 'auto',
                    ]
                ],
            ];
        }
        if (!empty($arRequest['t'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $arRequest['t'],
                        'fuzziness' => 'auto',
                    ],
                ],
            ];
        }
        if (!empty($arRequest['p'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'range' => [
                    'price' => [
                        'lte' => $arRequest['p'],
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
