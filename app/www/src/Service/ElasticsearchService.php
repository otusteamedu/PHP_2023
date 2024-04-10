<?php


namespace App\Service;

use App\Dto\SearchDto;
use App\ElasticsearchBase;
use Shasoft\Console\Console;

class ElasticsearchService extends ElasticsearchBase
{

    public function __construct()
    {
        parent::__construct();
    }

    public function executeCommand(SearchDto $argv): void
    {

        $arg_1 = $argv->getCommand();

        if (empty($arg_1)) {
            echo "Не указана команда." . PHP_EOL;
            return;
        }

        switch ($arg_1) {
            case 'cleanup':
                $cleanup = new ElasticsearchCleanup();
                $cleanup->clearIndex();
                break;
            case 'createIndex':
                $start = new ElasticsearchStart();
                $start->createIndex();
                $start->bulkData();
                break;
            case 'allData':
                $this->allData();
                break;
            case 'search':
                $this->searchArgv($argv);
                break;
            default:
                echo "Неверная команда." . PHP_EOL;
        }
    }

    private function searchArgv(SearchDto $argv): void
    {
        $title = $category = $minPrice = $maxPrice = null;

        foreach ($argv as $arg) {
            $item = explode("=", $arg);
            if ($item[0] == 'title') {
                $title = $item[1];
            } elseif ($item[0] == 'category') {
                $category = $item[1];
            } elseif ($item[0] == 'minPrice') {
                $minPrice = $item[1];
            } elseif ($item[0] == 'maxPrice') {
                $maxPrice = $item[1];
            }
        }

        $this->searchData($title, $category, $minPrice, $maxPrice);
    }



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
