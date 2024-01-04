<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cases\Php2023\ClientElasticSearch;

$value = (string) $_POST['value'];
$priceLte = (int) $_POST['priceLte'];


$client = new ClientElasticSearch();
$clientElastic = $client->getClient();

$array = [
    'index' => 'otus-shop',
    'size' => 99,
    'body' => [
        "query" => [
            "bool" => [
                "must" => [
                    [
                        "fuzzy" => [
                            "title" => [
                                "value" => $value,
                                "fuzziness" => "AUTO"
                            ]
                        ]
                    ],
                    [
                        "range" => [
                            "price" => [
                                "lte" => $priceLte
                            ]
                        ]
                    ]
                ],
                "filter" => [
                    "nested" => [
                        "path" => "stock",
                        "query" => [
                            "range" => [
                                "stock.stock" => [
                                    "gt" => 0
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$response = $clientElastic->search($array);
