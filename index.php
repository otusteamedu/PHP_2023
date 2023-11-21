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
            'bool' => [
                'filter' => [
                    'range' => [
                        'price' => [
                            'gte' => $price,
                        ],
                    ],
                ],
                'must' => [
                    'match' => [
                        'title.keyword' => $title,
                    ],
                ],
                'should' => [
                    'term' => [
                        'category.keyword' => $category,
                    ],
                ],
            ],
        ],
        'size' => 3,
    ]
];
$response = $client->search($params)->asArray();
var_dump($response);
