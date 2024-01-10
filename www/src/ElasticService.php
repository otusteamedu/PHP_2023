<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

/**
 * Класс для работы с ElasticSearch
 * - загрузка индекса
 * - поиск книг
 */
class ElasticService
{
    private Client $client;

    private array $mapping = [
        'mappings' => [
            'properties' => [
                'category' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'price' => [
                    'type' => 'long',
                ],
                'sku' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256,
                                ],
                            ],
                        ],
                        'stock' => [
                            'type' => 'long',
                        ],
                    ],
                ],
                'title' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
            ],
        ],
    ];

    private array $searchTemplate = [
        'index' => 'otus-books',
        'scroll' => '1m',
        'size' => 50,
        'track_total_hits' => true,
        'body' => [
            'query' => [
                'bool' => [
                    'must' => [],
                    'filter' => [
                        [
                            'nested' => [
                                'path' => 'stock',
                                'query' => [
                                    'bool' => [
                                        'must' => []
                                    ]
                                ]
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ];

    /**
     * @throws AuthenticationException
     */
    public function __construct($server, $username, $password)
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://' . $server . ':9200'])
            ->setBasicAuthentication($username, $password)
            ->setSSLVerification(false)
            ->build();
    }

    /**
     * @param string $filePath Path to json file with data
     * @param string $indexName Index name
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function loadFromJson(string $filePath, string $indexName): void
    {
        if (!$this->isIndexExists($indexName)) {
            $this->createIndex($indexName);
        }

        $data = file_get_contents($filePath);
        var_dump($data);
        $lines = explode("\n", $data);

        $formatted = [];

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }
            $json = json_decode($line, true);

            $formatted[] = ['index' => ['_index' => $indexName]];
            $formatted[] = $json;
        }

        $this->client->bulk(['body' => $formatted]);
    }

    /**
     * Set search params in template
     *
     * @param string $type
     * @param string $value
     *
     * @return void
     */
    public function setSearchParam(string $type, string $value): void
    {
        switch ($type) {
            case 'title':
                $this->searchTemplate['body']['query']['bool']['must'] = [
                    'match' => [
                        'title' => [
                            'query' => $value,
                            'fuzziness' => '2',
                            'operator' => 'and',
                        ],
                    ]
                ];
                break;
            case 'category':
                $this->searchTemplate['body']['query']['bool']['filter'][] = [
                    'match' => [
                        'category' => $value,
                    ]
                ];
                break;
            case 'price':
                $value = $this->normalizeOperatrion($value);
                $this->searchTemplate['body']['query']['bool']['filter'][] = [
                    'range' => [
                        'price' => $value
                    ]
                ];
                break;
            case 'stock':
                $value = $this->normalizeOperatrion($value);
                $this->searchTemplate['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
                    'range' => [
                        'stock.stock' => $value
                    ]
                ];
                break;
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(): Elasticsearch|Promise
    {
        return $this->client->search($this->searchTemplate);
    }

    /**
     * @param array $params
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function scroll(array $params): Elasticsearch|Promise
    {
        return $this->client->scroll($params);
    }

    /**
     * Normalize operators for Elastic
     *
     * @param string $value
     *
     * @return int[]
     */
    private function normalizeOperatrion(string $value): array
    {
        $digit = (int)preg_replace('/[><=]/', '', $value);

        $operators = [
            '<=' => 'lte',
            '>=' => 'gte',
            '<'  => 'lt',
            '>'  => 'gt',
        ];

        foreach ($operators as $operatorString => $operator) {
            if (str_contains($value, $operatorString)) {
                return [$operator => $digit];
            }
        }

        return [
            'lte' => $digit,
            'gte' => $digit,
        ];
    }

    /**
     * @param string $indexName Index Name
     * @return bool
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    private function isIndexExists(string $indexName): bool
    {
        return $this->client->indices()->exists(['index' => $indexName])->getStatusCode() === 200;
    }

    /**
     * @param string $indexName Index name
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndex(string $indexName): void
    {
        if ($this->isIndexExists($indexName)) {
            return;
        }

        $params = [
            'index' => $indexName,
            'body' => $this->mapping,
        ];
        $this->client->indices()->create($params);
    }
}
