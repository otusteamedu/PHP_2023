<?php

namespace Gkarman\Otuselastic\Repositories;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Gkarman\Otuselastic\Dto\BookDto;

class ElasticRepository implements RepositoryInterface
{
    const INDEX_NAME = 'otus-shop';

    private Client $elasticClient;

    public function __construct()
    {
        $this->elasticClient = ClientBuilder::create()
            ->setHosts([$this->getElasticHost()])
            ->build();
    }

    public function createDB(): string
    {
        $params = [
            'index' => self::INDEX_NAME,
            'body' => [
                'settings' => [
                    'analysis' => [
                        'filter' => [
                            'ru_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_russian_',
                            ],
                            'ru_stemmer' => [
                                'type' => 'stemmer',
                                'language' => 'russian',
                            ],
                        ],
                        'analyzer' => [
                            'my_russian' => [
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase',
                                    'ru_stop',
                                    'ru_stemmer',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $this->elasticClient->indices()->create($params);
    }

    public function importDB(): string
    {
        $data = file_get_contents("src/Storage/books.json");

        $ch = curl_init($this->getElasticHost() . '/_bulk/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, 1);
        $result = empty($res['errors']) ? 'ok' : 'есть ошибки при добавлении';

        return $result;
    }

    public function deleteDB(): string
    {
        $params = ['index' => self::INDEX_NAME];
        $response = $this->elasticClient->indices()->delete($params);
        return $response;
    }

    public function searchBooks(): array
    {
        $countItems = 100;
        $category = 'Исторический роман';
        $title = 'рыцОри';
        $priceMAX = 2000;
        $stockMIN = 0;

        $params = [
            'index' => self::INDEX_NAME,
            'size' => $countItems,
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            ['term' => ['category.keyword' => $category]],
                            ['range' => ['price' => ['lt' => $priceMAX]]],
                            ['range' => ['stock.stock' => ['gte' => $stockMIN]]],
                        ],
                        'must' => [
                            'match' =>
                                [
                                    'title' => ['query' => $title, 'fuzziness' => 'AUTO',],
                                ],
                        ],
                    ],
                ],
            ],
        ];

        $result = $this->elasticClient->search($params)->asArray();
        $hits = $result['hits']['hits'] ?? [];

        $books = [];
        foreach ($hits as $hit) {
            $book = new BookDto($hit['_source']);
            $books[] = $book;
        }

        return $books;
    }

    private function getElasticHost(): string
    {
        return (parse_ini_file("src/Configs/elastic.ini"))['host'] ?? '';
    }
}

