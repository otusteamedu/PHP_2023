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

    /**
     *
     */
    public function __construct()
    {
        $this->connection = ElasticConnection::getInstance();
    }

    /**
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     */
    public function create(): void
    {
        $index = $this->connection->getConnection()->indices()->exists(['index' => self::INDEX_NAME]);

        if ($index->getStatusCode() == 404) {
            $this->connection->getConnection()->indices()->create([
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
        }
    }

    public function deleteIndex(): void
    {
        try {
            $this->connection->getConnection()->indices()->delete(['index' => self::INDEX_NAME]);
        } catch (ClientResponseException $e) {
            echo 'Ошибка при удалении индекса: ' . $e->getMessage() . "\n";
        }
    }

    /**
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function loadData(): void
    {
        $content = file_get_contents(App::getInstance()->getDocumentRoot() . '/data/books.json');

        $this->connection->getConnection()->bulk([
            'index' => self::INDEX_NAME,
            'body' => $content
        ]);
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
