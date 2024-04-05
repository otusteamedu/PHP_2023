<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use Shasoft\Console\Console;

class MainElasticsearch {

    private Client $client;
    private const INDEX_NAME = 'otus-shop';
    private const FILE_NAME = __DIR__ . '/../books.json';

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', 'elastic123')
            ->build();
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

    public function bulkData(){

        $this->client = ClientBuilder::create()
            ->setHosts(['https://elasticsearch:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', 'elastic123')
            ->build();

        $data = file_get_contents(self::FILE_NAME);

        // Проверяем, что файл содержит данные
        if (empty($data)) {
            die('Файл books.json пуст или отсутствует.');
        }

        $params = ['body' => file_get_contents(self::FILE_NAME)];

        $response = $this->client->bulk($params);

        if ($response['errors'] === false) {
            echo 'Данные успешно загружены в Elasticsearch.';
        } else {
            echo 'При загрузке данных возникли ошибки: ' . json_encode($response['items']);
        }
    }

    public function getAllData()
    {

        $params = [
            'index' => self::INDEX_NAME,
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

