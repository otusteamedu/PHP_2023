<?php

namespace App;


class ElasticsearchStart extends ElasticsearchBase
{

    public function createIndex(): void
    {
        $settings = [
            'index' => $this->getIndexName(),
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

        $data = file_get_contents($this->getFileName());

        // Проверяем, что файл содержит данные
        if (empty($data)) {
            die('Файл books.json пуст или отсутствует.');
        }

        $params = ['body' => $data];

        $response = $this->client->bulk($params);

        if ($response['errors'] === false) {
            echo 'Данные успешно загружены в Elasticsearch.';
        } else {
            echo 'При загрузке данных возникли ошибки: ' . json_encode($response['items']);
        }
    }

}

