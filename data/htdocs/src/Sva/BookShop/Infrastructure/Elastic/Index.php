<?php

namespace Sva\BookShop\Infrastructure\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Sva\Common\App\App;
use Sva\Common\Infrastructure\ElasticConnection;

class Index
{
    const INDEX_NAME = 'otus-shop';
    private ElasticConnection $connection;

    public function __construct()
    {
        $this->connection = ElasticConnection::getInstance();
    }

    public function helthcheck()
    {
        $r = $this->connection->getConnection()->healthReport();
    }

    public function create(): bool
    {
        try {
            $index = $this->connection->getConnection()->indices()->get(['index' => self::INDEX_NAME]);
        } catch (\Exception $e) {
            if ($e->getCode() == 404) {
                $r = $this->connection->getConnection()->indices()->create([
                    'index' => self::INDEX_NAME,
                    'body' => [
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
                                'analyzer' => [
                                    'my_russian' => [
                                        'tokenizer' => 'standard',
                                        'filter' => [
                                            'lowercase',
                                            'ru_stop',
                                            'ru_stemmer'
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'mappings' => [
                            'properties' => [
                                'title' => [
                                    'type' => 'text',
                                    'analyzer' => 'my_russian'
                                ],
                                'sku' => [
                                    'type' => 'keyword'
                                ],
                                'category' => [
                                    "type" => 'keyword'
                                ],
                                'price' => [
                                    'type' => 'double'
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
                        ]
                    ]
                ]);

                return $r->getStatusCode() == 200;
            }
        }

        return false;
    }

    public function deleteIndex(): bool
    {
        try {
            $r = $this->connection->getConnection()->indices()->delete(['index' => self::INDEX_NAME]);
            return $r->getStatusCode() == 200;
        } catch (\Exception $e) {

        }

        return false;
    }

    public function loadData(): void
    {
        $content = file_get_contents(App::getInstance()->getDocumentRoot() . '/data/books.json');

        try {
            $r = $this->connection->getConnection()->bulk([
                'index' => self::INDEX_NAME,
                'body' => $content
            ]);

            if ($r) {
                echo "Data loaded\n";
            } else {
                echo "Data not loaded\n";
            }
        } catch (\Exception $e) {
            echo "Data not loaded: " . $e->getMessage() . "\n";
        }
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(Filter $filter): array
    {
        $arParams = [
            'index' => self::INDEX_NAME
        ];
        $arFilter = $filter->get();

        if (!empty($arFilter)) {
            $arParams['body'] = $arFilter;
        }

        $r = $this->connection->getConnection()->search($arParams);

        return $r->asArray();
    }

}
