<?php

declare(strict_types=1);

namespace Klobkovsky\App;

use Klobkovsky\App\Exceptions\DocumentCreateException;
use Klobkovsky\App\Exceptions\DocumentSearchException;
use Klobkovsky\App\Exceptions\IndexCreateException;
use Klobkovsky\App\Exceptions\IndexDeleteException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class ElasticService
{
    public const INDEX_NAME = 'otus-shop';
    private const BOOKS_DATA =  __DIR__ . '/../books.json';

    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', '123456')
            ->build();
    }

    public function createDocument(): void
    {
        $handle = fopen(self::BOOKS_DATA, 'r');

        while (!feof($handle)) {
            $line = fgets($handle);

            if (!empty($line)) {
                $document = json_decode($line, true);

                if (isset($document['create'])) {
                    $index = $document['create']['_index'];
                    $id = $document['create']['_id'];
                    $indexAndId = [
                        'index' => $index,
                        'id' => $id
                    ];
                }

                if (isset($document['title'])) {
                    $body = ['body' => $document];
                    $param = array_merge($indexAndId, $body);

                    try {
                        $this->client->index($param);
                    } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
                        throw new DocumentCreateException($e->getMessage());
                    }
                }
            }
        }

        fclose($handle);
    }

    public function createIndex(): void
    {
        $defaultIndex = [
            'index' => self::INDEX_NAME,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                        ],
                        'sku' => [
                            'type' => 'keyword'
                        ],
                        'category' => [
                            'type' => 'text'
                        ],
                        'price' => [
                            'type' => 'short'
                        ],
                        'stock' => [
                            'type' => 'nested',
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword'
                                ],
                                'stock' => [
                                    'type' => 'short'
                                ]
                            ]
                        ]
                    ]
                ],
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_'
                            ],
                            'ru_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian'
                            ]
                        ],
                        "analyzer" => [
                            "my_russian" => [
                                'tokenizer' => 'standard',
                                "filter" => [
                                    "lowercase",
                                    "ru_stop",
                                    "ru_stemmer"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        try {
            $this->client->indices()->create($defaultIndex);
        } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
            throw new IndexCreateException($e->getMessage());
        }
    }

    public function deleteIndex(): void
    {
        try {
            $this->client->indices()->delete(['index' => self::INDEX_NAME]);
        } catch (ClientResponseException | MissingParameterException | ServerResponseException $e) {
            throw new IndexDeleteException($e->getMessage());
        }
    }

    public function searchDocument(string $title = '', string $category = '', int $price = 0): Elasticsearch|Promise
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    'title' => [
                                        'query' => $title,
                                        'fuzziness' => 'auto'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "category" => [
                                        "query" => $category,
                                        'fuzziness' => 'auto'
                                    ]
                                ]
                            ],
                            [
                                "range" => [
                                    "price" => [
                                        "lte" => $price
                                    ]
                                ]
                            ],
                            [
                                "nested" => [
                                    "path" => "stock",
                                    "query" => [
                                        "range" => [
                                            "stock.stock" => [
                                                "gte" => 1
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];

        try {
            $response = $this->client->search($params);
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new DocumentSearchException($e->getMessage());
        }

        return $response;
    }
}
