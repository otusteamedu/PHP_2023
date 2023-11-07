<?php

declare(strict_types=1);

namespace Gesparo\ES\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Gesparo\ES\Search\Price;
use Gesparo\ES\Search\ResponseElement;
use Gesparo\ES\Search\Title;

class Searcher
{
    private Client $elasticClient;
    private string $index;

    public function __construct(Client $elasticClient, string $index)
    {
        $this->elasticClient = $elasticClient;
        $this->index = $index;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(Price $price, Title $title): array
    {
        $response = $this->elasticClient->search($this->getParams($price, $title));

        return $this->prepareResponse($response);
    }

    private function getParams(Price $price, Title $title): array
    {
        return [
            'index' => $this->index,
            'size' => 10,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => $title->get()
                                ]
                            ],
                        ],
                        'filter' => [
                            [
                                'range' => [
                                    'price' => [
                                        'lte' => $price->get()
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @param Elasticsearch $elasticResponse
     * @return ResponseElement[]
     */
    private function prepareResponse(Elasticsearch $elasticResponse): array
    {
        $results = $elasticResponse['hits']['hits'] ?? [];
        $elements = [];

        foreach ($results as $result) {
            $elements[] = new ResponseElement(
                $result['_index'],
                $result['_id'],
                $result['_score'],
                $result['_source']
            );
        }

        return $elements;
    }
}
