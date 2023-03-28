<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use LucidFrame\Console\ConsoleTable;
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
        if (!$searchParams->getQuery()) {
            return new ResultSearch(false, Message::FAILED_SEARCH_QUERY);
        }

        try {
            $must['match'] = [
                'title' => [
                    'query' => $searchParams->getQuery(),
                    'fuzziness' => 'auto',
                ]
            ];

            $filter = [];

            if ($searchParams->getMaxPrice()) {
                $filter[] = $this->getDefaultFilter();
                $filter[] = $this->getPriceFilter($searchParams);
            }

            if ($searchParams->getCategory()) {
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

            $table = $this->createConsoleTable($response['hits']['hits']);
            return new ResultSearch(
                true,
                sprintf(Message::COUNT_HITS, $response['hits']['total']['value']),
                $table
            );

        } catch (ClientResponseException | ServerResponseException $e) {
            return new ResultSearch(false, $e->getMessage());
        }
    }

    private function createConsoleTable(array $documents): ConsoleTable
    {
        $table = new ConsoleTable();
        $table
            ->addHeader('title')
            ->addHeader('sku')
            ->addHeader('score')
            ->addHeader('category')
            ->addHeader('price')
            ->addHeader('total_stock');

        foreach ($documents as $document) {
            $table->addRow()
                ->addColumn($document['_source']['title'])
                ->addColumn($document['_source']['sku'])
                ->addColumn(round($document['_score'], 2))
                ->addColumn($document['_source']['category'])
                ->addColumn($document['_source']['price'])
                ->addColumn($this->getTotalStock($document['_source']['stock']));
        }
        return $table;
    }

    private function getTotalStock(array $stock): int
    {
        $total = 0;

        foreach ($stock as $shop) {
            $total += $shop['stock'];
        }

        return $total;
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
                    'lt' => $searchParams->getMaxPrice(),
                ]
            ]
        ];
    }

    private function getCategoryFilter(SearchParams $searchParams): array
    {
        return [
            'term' => [
                'category' => $searchParams->getCategory(),
            ],
        ];
    }
}
