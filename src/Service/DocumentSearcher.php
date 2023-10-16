<?php

declare(strict_types=1);

namespace App\Service;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class DocumentSearcher extends ElasticServiceTemplate
{
    public function execute(string $indexName, string $title, string $category, int $price): Elasticsearch|Promise
    {
        $params = [
            'index' => $indexName,
            'body' => [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    'title' => [
                                        'query' => $title,
                                        'fuzziness' => 'auto'
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "category" => [
                                        "query" => $category,
                                        'fuzziness' => 'auto'
                                    ]
                                ]
                            ],
                            [
                                "range" => [
                                    "price" => [
                                        "lte" => $price
                                    ]
                                ]
                            ],
                            [
                                "nested" => [
                                    "path" => "stock",
                                    "query" => [
                                        "range" => [
                                            "stock.stock" => [
                                                "gte" => 1
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];


        try {
            $response = $this->client->search($params);
        } catch (ClientResponseException | ServerResponseException $e) {
            echo $e->getMessage();
        }

        return $response;
    }
}
