<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Vp\App\Config;
use Vp\App\DTO\Message;
use Vp\App\DTO\SearchParams;
use Vp\App\Result\ResultSearch;

class Search
{
    use StorageClient;

    private Client $client;
    private string $indexName;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = $this->getClient();
        $this->indexName = Config::getInstance()->getIndexName();
    }
    public function work(SearchParams $searchParams): ResultSearch
    {
        if (!$searchParams->query) {
            return new ResultSearch(false, Message::FAILED_SEARCH_QUERY);
        }

        try {
            $must['match'] = [
                'title' => [
                    'query' => $searchParams->query,
                    'fuzziness' => 'auto',
                ]
            ];

            $filter = [];

            if ($searchParams->maxPrice) {
                $filter[] = $this->getDefaultFilter();
                $filter[] = $this->getPriceFilter($searchParams);
            }

            if ($searchParams->category) {
                $filter[] = $this->getCategoryFilter($searchParams);
            }

            $response = $this->client->search([
                'index' => $this->indexName,
                'size' => Config::getInstance()->getSize(),
                'body' => [
                    'query' => [
                        'bool' => [
                            'must' => $must,
                            'filter' => $filter
                        ]
                    ],
                ]
            ]);

            if ($response['hits']['total']['value'] < 1) {
                return new ResultSearch(false, Message::EMPTY_HITS);
            }

            return new ResultSearch(
                true,
                sprintf(Message::COUNT_HITS, $response['hits']['total']['value']),
                $response['hits']['hits']
            );
        } catch (ClientResponseException | ServerResponseException $e) {
            return new ResultSearch(false, $e->getMessage());
        }
    }

    private function getDefaultFilter(): array
    {
        return [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'filter' => [
                            'range' => [
                                'stock.stock' => [
                                    'gte' => 0
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    private function getPriceFilter(SearchParams $searchParams): array
    {
        return [
            'range' => [
                'price' => [
                    'gte' => 0,
                    'lt' => $searchParams->maxPrice,
                ]
            ]
        ];
    }

    private function getCategoryFilter(SearchParams $searchParams): array
    {
        return [
            'term' => [
                'category' => $searchParams->category,
            ],
        ];
    }
}
