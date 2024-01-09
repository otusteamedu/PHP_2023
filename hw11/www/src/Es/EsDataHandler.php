<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Es;

use Elastic\Elasticsearch\Client;

class EsDataHandler
{
    private Client $esConnection;
    private string $esIndexName;
    private array $arCliArgv;

    /**
     * @throws \Exception
     */
    public function __construct(EsConnection $connection, array $arCliArgv, string $esIndexName)
    {
        $this->esConnection = $connection->getClient();
        $this->arCliArgv = $arCliArgv;
        $this->esIndexName = $esIndexName;
    }

    public function getData(): array
    {
        $response = $this->esConnection->search($this->getQuery());
        if ($response['hits']['total']['value'] > 0) {
            return $response['hits']['hits'];
        }
        return [];
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

        if (!empty($this->arCliArgv['c'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'match' => [
                    'category' => [
                        'query' => $this->arCliArgv['c'],
                        'fuzziness' => 'auto',
                    ]
                ],
            ];
        }
        if (!empty($this->arCliArgv['t'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $this->arCliArgv['t'],
                        'fuzziness' => 'auto',
                    ],
                ],
            ];
        }
        if (!empty($this->arCliArgv['p'])) {
            $arReturn['body']['query']['bool']['must'][] = [
                'range' => [
                    'price' => [
                        'lte' => $this->arCliArgv['p'],
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
