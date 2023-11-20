<?php

use Elastic\Elasticsearch\ClientBuilder;

require_once __DIR__ . '/vendor/autoload.php';

$client = ClientBuilder::create()
    ->setHosts(['http://localhost:9200'])
    ->build();

$params = [
    'index' => 'otus-shop',
    'body' => [
        'query' => [
            'match' => [
                'sku' => '500-003',
            ]
        ],
        'size' => 1,
    ]
];
$response = $client->search($params)->asArray();
var_dump($response);
