<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;


class MainElasticsearch {

    private Client $client;
    private const INDEX_NAME = 'otus-shop';
    private const FILE_NAME = __DIR__ . '/books.json';

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', 'elastic123')
            ->build();
    }

    public function createIndex(): void
    {
        $settings = [
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
                            'type' => 'integer'
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

        $this->client->indices()->create($settings);
    }

    public function search($query)
    {
        return $this->client->search($query);
    }

}