<?php

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchBase
{
    protected Client $client;
    protected const INDEX_NAME = 'otus-shop';
    protected const FILE_NAME = __DIR__ . '/../books.json';

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ES_PORT']])
            ->setSSLVerification(false)
            ->setBasicAuthentication($_ENV['ELASTIC_USERNAME'], $_ENV['ELASTIC_PASSWORD'])
            ->build();
    }

    protected function getIndexName()
    {
        return self::INDEX_NAME;
    }

    protected function getFileName()
    {
        return self::FILE_NAME;
    }

    protected function getSettings()
    {
        $settings = [
            'index' => $this->getIndexName(),
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
        return $settings;
    }

}
