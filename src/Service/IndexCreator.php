<?php

declare(strict_types=1);

namespace App\Service;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class IndexCreator extends ElasticServiceTemplate
{
    private array $defaultIndex = [
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

    public function execute(string $indexName): void
    {
        $this->defaultIndex['index'] = $indexName;

        try {
            $this->client->indices()->create($this->defaultIndex);
        } catch (ClientResponseException|MissingParameterException|ServerResponseException $e) {
            echo $e->getMessage();
        }
    }
}