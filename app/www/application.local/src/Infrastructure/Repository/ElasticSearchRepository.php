<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Infrastructure\Repository;

use AYamaliev\hw11\Application\Dto\SearchDto;
use AYamaliev\hw11\Domain\Repository\BookRepositoryInterface;
use AYamaliev\hw11\Infrastructure\ElasticSearchQuery;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class ElasticSearchRepository implements BookRepositoryInterface
{
    private Client $client;
    private const INDEX_NAME = 'otus-shop';
    private const BULK_FILE_NAME = __DIR__ . '/../../../books.json';

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication($_ENV['ELASTIC_USERNAME'], $_ENV['ELASTIC_PASSWORD'])
            ->build();
    }

    public function search(SearchDto $searchDto): Elasticsearch|Promise
    {
        if (!$this->isRepositoryExist()) {
            $this->initRepository();
        }

        $query = ((new ElasticSearchQuery(self::INDEX_NAME, $searchDto))());
        return $this->client->search($query);
    }

    private function isRepositoryExist(): bool
    {
        $response = $this->client->indices()->exists(['index' => self::INDEX_NAME]);
        return ($response->getStatusCode() === 200);
    }

    private function initRepository(): void
    {
        $this->createIndex();
        $this->bulkData();
    }

    public function createIndex(): void
    {
        $settings = [
            'index' => self::INDEX_NAME,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                        ],
                        'sku' => [
                            'type' => 'keyword'
                        ],
                        'category' => [
                            'type' => 'text'
                        ],
                        'price' => [
                            'type' => 'integer'
                        ],
                        'stock' => [
                            'type' => 'nested',
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword'
                                ],
                                'stock' => [
                                    'type' => 'short'
                                ]
                            ]
                        ]
                    ]
                ],
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_'
                            ],
                            'ru_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian'
                            ]
                        ],
                        "analyzer" => [
                            "my_russian" => [
                                'tokenizer' => 'standard',
                                "filter" => [
                                    "lowercase",
                                    "ru_stop",
                                    "ru_stemmer"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->client->indices()->create($settings);
    }

    private function bulkData(): void
    {
        $data = $this->getData();
        $this->requestBulk($data);
    }

    private function getData(): string
    {
        return file_get_contents(self::BULK_FILE_NAME) ?? '';
    }

    private function requestBulk(string $data): void
    {
        $params = [
            'body' => $data
        ];
        $this->client->bulk($params);
    }

    private function deleteIndex()
    {
        $params = [
            'index' => self::INDEX_NAME,
        ];

        $this->client->indices()->delete($params);
    }

    private function getMapping()
    {
        $params = [
            'index' => self::INDEX_NAME,
        ];
        $response = $this->client->indices()->getMapping($params);
        return $response[self::INDEX_NAME]['mappings'];
    }

    private function getAllData()
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'query' => [
                    'match_all' => (object)[],
                ],
            ],
        ];

        $response = $this->client->search($params);

        return $response['hits']['total']['value'];
    }
}
