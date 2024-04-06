<?php


namespace App\Service;

use App\ElasticsearchBase;
use Shasoft\Console\Console;

class ElasticsearchService extends ElasticsearchBase
{

    public function allData()
    {

        $params = [
            'index' => $this->getIndexName(),
            'body' => [
                'query' => [
                    'match_all' => (object)[]
                ]
            ]
        ];

        // Выполняем запрос к Elasticsearch
        $response = $this->client->search($params);

        // Обрабатываем результаты запроса
        $hits = $response['hits']['hits'];
        foreach ($hits as $hit) {
            // Выводим данные документа
            var_dump($hit['_source']);
        }
    }

    public function searchData($title = null, $category = null, $minPrice = null, $maxPrice = null)
    {

        $params = [
            'index' => 'otus-shop',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => []
                    ]
                ]
            ]
        ];

        if (!empty($title)) {
            $params['body']['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $title,
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ];
        }

        if (!empty($category)) {
            $params['body']['query']['bool']['must'][] = [
                'match' => [
                    'category' => [
                        'query' => $category,
                        'fuzziness' => 'AUTO'
                    ]
                ]
            ];
        }

        if (!empty($minPrice) && !empty($maxPrice)) {
            $params['body']['query']['bool']['filter'] = [
                'range' => [
                    'price' => [
                        'gte' => $minPrice,
                        'lte' => $maxPrice
                    ]
                ]
            ];
        } elseif (!empty($minPrice)) {
            $params['body']['query']['bool']['filter'] = [
                'range' => [
                    'price' => [
                        'gte' => $minPrice
                    ]
                ]
            ];
        } elseif (!empty($maxPrice)) {
            $params['body']['query']['bool']['filter'] = [
                'range' => [
                    'price' => [
                        'lte' => $maxPrice
                    ]
                ]
            ];
        }


        $response = $this->client->search($params);


        if (!empty($response['hits']['hits'])) {
            foreach ($response['hits']['hits'] as $hit) {
                $source = $hit['_source'];

                Console::writeln('Найден товар: ' . $source['title'] . ' ' .
                    ', Цена: ' . $source['price'] . ' ' .
                    ', Категория: ' . $source['category'] . ' ');
            }
        } else {
            echo 'По вашему запросу ничего не найдено.';
        }

    }

}
