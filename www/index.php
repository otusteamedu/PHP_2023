<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Chernomordov\App\ElasticsearchService;

$indexSettings = [
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

$elasticsearchService = new ElasticsearchService('elastic', '123456');

$elasticsearchService->setDataBulk(__DIR__ . '/books.json', 'otus-shop');
