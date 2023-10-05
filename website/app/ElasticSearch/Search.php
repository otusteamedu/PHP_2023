<?php

declare(strict_types=1);

namespace App\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final class Search
{
    public function __construct(
        private readonly Client $client,
        private readonly string $index,
    )
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(string $query, int $maxPrice): array
    {
        $output = [];

        $query = [
            'match' => [
                'title' => [
                    'query' => $query,
                    'fuzziness' => 'auto'
                ]
            ]
        ];
        if ($maxPrice > 0) {
            $query = [
                'bool' => [
                    'must' => [
                        $query,
                    ],
                    'filter' => [
                        'range' => [
                            'price' => [
                                'lte' => $maxPrice
                            ]
                        ]
                    ]
                ]
            ];
        }

        $result = $this->client->search([
            'index' => $this->index,
            'body' => [
                'query' => $query
            ]
        ])->asArray();
        if ($result) {
            foreach ($result['hits']['hits'] ?: [] as $item) {
                $output[] = sprintf('%s (%s): %s', $item['_source']['title'], $item['_source']['sku'], $item['_source']['price']);
            }

        }
        return $output;
    }
}