<?php

namespace Radovinetch\Hw11;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use JsonException;
use Throwable;

class Storage
{
    protected Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->setBasicAuthentication($_ENV['ELASTIC_USER'], $_ENV['ELASTIC_PASSWORD'])
            ->setCABundle(dirname(__DIR__, 2) . '/' . $_ENV['ELASTIC_PATH_TO_CERT'])
            ->build();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndex(): void
    {
        $this->client->indices()->create([
            'index' => $_ENV['ELASTIC_INDEX_NAME'],
            'body' => [
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_'
                            ],
                            'ru_stemmer' => [
                                'type'      => 'stemmer',
                                'language'  => 'russian'
                            ]
                        ],
                        'analyzer' => [
                            'my_russian' => [
                                'tokenizer' => 'standard',
                                'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'title' => [
                            'type' => 'text'
                        ],
                        'sku' => [
                            'type' => 'keyword'
                        ],
                        'category' => [
                            'type' => 'keyword'
                        ],
                        'price' => [
                            'type' => 'short'
                        ],
                        'stock' => [
                            'type' => 'nested',
                            'properties' => [
                                'shop'  => ['type' => 'keyword'],
                                'stock' => ['type' => 'short']
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function deleteIndex(): void
    {
        $this->client->indices()->delete([
            'index' => $_ENV['ELASTIC_INDEX_NAME']
        ]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function bulk(): void
    {
        $params = ['body' => file_get_contents(dirname(__DIR__, 2) . '/' . 'books-39289-aa67f1.json')];
        $this->client->bulk($params);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(
        string $query,
        int $price
    ): Elasticsearch
    {
        return $this->client->search([
            'index' => $_ENV['ELASTIC_INDEX_NAME'],
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => [
                                        'query' => $query,
                                        'fuzziness' => 'auto'
                                    ],
                                ]
                            ],
                            [
                                'range' => ['price' => ['lt' => $price]]
                            ],
                            [
                                'nested' => [
                                    'path' => 'stock',
                                    'query' => [
                                        'bool' => [
                                            'must' => [
                                                'range' => ['stock.stock' => ['gt' => 0]]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        ]);
    }
}