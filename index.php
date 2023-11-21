<?php

use Elastic\Elasticsearch\ClientBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$category = (string)readline('Type book category: ');
$price = (float)readline('Type book price: ');
$title = (string)readline('Type book title: ');

$client = ClientBuilder::create()
    ->setHosts(['http://localhost:9200'])
    ->build();

$params = [
    'index' => 'otus-shop',
    'body' => [
        'query' => [
            'bool' => [
                'filter' => [
//                    'range' => [
//                        'price' => [
//                            'gte' => $price,
//                        ],
//                    ],
//                    'term' => [
//                        'category' => $category,
//                    ],
                ],
                'should' => [
                    'match' => [
                        'title' => $title,
                    ],
                ],
            ],
        ],
        'size' => 1,
    ]
];
$response = $client->search($params)->asObject();
var_dump($response);
