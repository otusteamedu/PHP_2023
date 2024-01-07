<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Elasticsearch\CommandActionInterface;
use App\Elasticsearch\Client;
use Models\BookStoreModel;

class SearchAction implements CommandActionInterface
{
    public $params;
    public $result;
    public $error;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function do(): void
    {
        $client = Client::connect();
        $this->prepareParams();

        $this->result = $client->search($this->prepareParams());
    }

    private function prepareParams(): array
    {
        $params = [];
        $filter = [];
        $must   = [];
        $price  = [];

        $params['index'] = BookStoreModel::INDEX_NAME;

        if ($this->params['category']) {
            $filter[] = [
                'match' => [
                    'category.keyword' => $this->params['category']
                ]
            ];
        }

        if ($this->params['minPrice'] && $this->params['maxPrice']) {
            $price = [
                'gte' => $this->params['minPrice'],
                'lt' => $this->params['maxPrice']
            ];
        } elseif ($this->params['minPrice'] && !$this->params['maxPrice']) {
            $price = [
                'gte' => $this->params['minPrice']
            ];
        } elseif (!$this->params['minPrice'] && $this->params['maxPrice']) {
            $price = [
                'lt' => $this->params['maxPrice']
            ];
        }

        if ($price) {
            $filter[]['range']['price'] = $price;
        }

        if ($this->params['inStock']) {
            $filter[]['range']['stock.stock'] = ['gte' => 1];
        }

        $must = [
            'match' => [
                'title' => [
                    'fuzziness' => 'auto',
                    'query' => $this->params['query']
                ]
            ]
        ];

        $params['body'] = [
            'query' => [
                'bool' => [
                    'must'   => $must,
                    'filter' => $filter
                ]
            ]
        ];

        return $params;
    }

    public function getResult(): array
    {
        return $this->result['hits']['hits'];
    }

    public function getMessage(): string
    {
        return '';
    }

    public function getError(): string | null
    {
        return '';
    }
}
