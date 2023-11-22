<?php

use Elastic\Elasticsearch\ClientBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$category = (string)readline('Enter book category: ');
$price = (float)readline('Enter book price: ');
$title = (string)readline('Enter book title: ');

$client = ClientBuilder::create()
    ->setHosts(['http://localhost:9200'])
    ->build();

$params = [
    'index' => 'otus-shop',
    'body' => [
        'query' => [
            'nested' => [
                'path' => 'stock',
                'ignore_unmapped' => true,
                'query' => [
                    'bool' => [
                        'filter' => [
                            [
                                'range' => [
                                    'price' => [
                                        'gte' => $price,
                                    ],
                                ],
                            ],
                            [
                                'range' => [
                                    'stock.stock' => [
                                        'gte' => 0,
                                    ],
                                ],
                            ],
                        ],
                        'must' => [
                            'match' => [
                                'category' => $category,
                            ],
                        ],
                        'should' => [
                            'match' => [
                                'title' => $title,
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'size' => 10,
    ]
];
$response = $client->search($params)->asArray();
var_dump($response);
