<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\DocumentCreateException;
use App\Exceptions\DocumentSearchException;
use App\Exceptions\IndexCreateException;
use App\Exceptions\IndexDeleteException;
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
    private const BOOKS_DATA =  __DIR__ . '/../../books.json';

    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setBasicAuthentication('elastic', '123456')
            ->setCABundle('http_ca.crt')
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
                    } catch (ClientResponseException | MissingParameterException | ServerResponseException) {
                        throw new DocumentCreateException();
                    }
                }
            }
        }

        fclose($handle);
    }

    public function createIndex(): void
    {
        $defaultIndex = [
            'index' => '....',
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
        } catch (ClientResponseException | MissingParameterException | ServerResponseException) {
            throw new IndexCreateException();
        }
    }

    public function deleteIndex(): void
    {
        try {
            $this->client->indices()->delete(['index' => self::INDEX_NAME]);
        } catch (ClientResponseException | MissingParameterException | ServerResponseException) {
            throw new IndexDeleteException();
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
        } catch (ClientResponseException | ServerResponseException) {
            throw new DocumentSearchException();
        }

        return $response;
    }
}
