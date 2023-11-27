<?php

require __DIR__ . '/vendor/autoload.php';

use App\ElasticSearchClient;
use App\IndexCreator;
use Elastic\Elasticsearch\ClientBuilder;


//$category = (string)readline('Enter book category: ');
//$price = (float)readline('Enter book price: ');
//$title = (string)readline('Enter book title: ');
//
//$client = ClientBuilder::create()
//    ->setHosts(['http://localhost:9200'])
//    ->build();
//
//$params = [
//    'index' => 'otus-shop',
//    'body' => [
//        'query' => [
//            'bool' => [
//                'filter' => [
//                    [
//                        'range' => [
//                            'price' => [
//                                'gte' => $price,
//                            ],
//                        ],
//                    ],
//                    [
//                        "nested" => [
//                            "path" => "stock",
//                            "query" => [
//                                "range" => [
//                                    "stock.stock" => [
//                                        "gte" => 1
//                                    ]
//                                ]
//                            ]
//                        ]
//                    ]
//                ],
//                'must' => [
//                    'match' => [
//                        'category' => $category,
//                    ],
//                ],
//                'should' => [
//                    'match' => [
//                        'title' => $title,
//                    ],
//                ],
//            ],
//        ],
//        'size' => 10,
//    ]
//];
//$response = $client->search($params)->asArray();
//var_dump($response);


$client = new ElasticSearchClient();
$creator = new \App\DocumentCreator($client);
$creator->execute();

//$client->getClient()->indices()->delete(['index' => 'otus-shop']);

//$indexCreator = new IndexCreator(new ElasticSearchClient());
//$indexCreator->execute('otus-shop');

