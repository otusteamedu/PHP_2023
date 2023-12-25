<?php

namespace Dimal\Hw11\Infrastructure;

use Dimal\Hw11\Entity\Book;
use Dimal\Hw11\Entity\SearchQuery;
use Elastic\Elasticsearch\ClientBuilder;


class ElasticSearchStockSearch extends AbstractStockSearch
{
    private $client;

    public function __construct($host, $password)
    {
        $this->client = ClientBuilder::create();
        $this->client->setHosts([$host]);
        if ($password) {
            $this->client->setApiKey($password);
        }

        $this->client = $this->client->build();
    }

    public function search(SearchQuery $sq)
    {
        $query = [
            'must' => [
                'match' => [
                    'title' => [
                        "query" => $sq->getTitle(),
                        'fuzziness' => "auto"
                    ]
                ],
            ]
        ];

        if ($sq->getCategory()) {
            $query['filter'] = [
                'term' => [
                    'category' => $sq->getCategory()
                ],
            ];
        }

        if ($sq->getMinPrice() || $sq->getMaxPrice()) {
            $range = [];
            if ($sq->getMinPrice()) {
                $range['gte'] = $sq->getMinPrice();
            }

            if ($sq->getMaxPrice()) {
                $range['lte'] = $sq->getMaxPrice();
            }
            $query['should'] = [
                'range' => ['price' => $range]
            ];

        }

        $params = [
            'index' => 'otus-shop',
            'size' => 20,
            'body' => [
                'query' => [
                    'bool' => $query
                ]
            ]
        ];

        $results = $this->client->search($params);
        $search_result = [];
        foreach ($results['hits']['hits'] as $item) {
            $source = $item['_source'];
            $avail = [];

            foreach ($source['stock'] as $s) {
                $avail[$s['shop']] = $s['stock'];
            }

            $book = new Book($source['sku'], $source['title'], $source['category'], $source['price'], $avail);
            array_push($search_result, $book);
        }

        return $search_result;
    }
}