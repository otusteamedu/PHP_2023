<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class DocumentSearcher
{
    public function __construct(private readonly ElasticSearchClient $elasticSearchClient)
    {
    }

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
            $response = $this->elasticSearchClient->getClient()->search($params);
        } catch (ClientResponseException | ServerResponseException $e) {
            echo $e->getMessage();
        }

        return $response;
    }
}
