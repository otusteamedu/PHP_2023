<?php
declare(strict_types=1);

namespace App\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClient
{
    private $client;

    public function __construct($host, $port)
    {
        $this->client = ClientBuilder::create()->setHosts([$host . ':' . $port])->build();
    }

    public function createIndex($indexName)
    {
        // Создание индекса
        $params = [
            'index' => $indexName,
        ];

        $this->client->indices()->create($params);
    }

    public function indexDocument($indexName, $document)
    {
        // Добавление документа в индекс
        $params = [
            'index' => $indexName,
            'body' => $document,
        ];

        $this->client->index($params);
    }

    public function search($indexName, $query)
    {
        // Поиск по индексу
        $params = [
            'index' => $indexName,
            'body' => [
                'query' => [
                    'match' => [
                        'title' => $query,
                    ],
                ],
            ],
        ];

        return $this->client->search($params);
    }
}
