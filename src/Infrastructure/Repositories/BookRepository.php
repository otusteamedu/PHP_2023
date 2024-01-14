<?php

declare(strict_types=1);

namespace src\Infrastructure\Repositories;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use src\Application\Repositories\BookRepositoryContract;
use src\Infrastructure\Repositories\Exceptions\DocumentSearchException;

require __DIR__ . '/../../Application/Repositories/BookRepositoryContract.php';
require __DIR__ . '/Exceptions/DocumentSearchException.php';

class BookRepository implements BookRepositoryContract
{
    public const INDEX_NAME = 'otus-shop';

    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $env = parse_ini_file('.env');

        $this->client = ClientBuilder::create()
            ->setHosts(['https://es01:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication($env['ES_USERNAME'], $env['ES_PASSWORD'])
            ->build();
    }

    /**
     * @throws DocumentSearchException
     */
    public function search(string $title, string $category, string $price): Elasticsearch|Promise
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    'title' => [
                                        'query' => $title,
                                    ],
                                ]
                            ],
                            [
                                "match" => [
                                    "category" => [
                                        "query" => $category,
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
                        ]
                    ]
                ],
            ]
        ];

        try {
            $response = $this->client->search($params);
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new DocumentSearchException();
        }
        return $response;
    }
}
