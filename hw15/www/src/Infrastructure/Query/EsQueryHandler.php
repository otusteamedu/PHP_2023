<?php

namespace Shabanov\Otusphp\Infrastructure\Query;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ElasticsearchException;
use Shabanov\Otusphp\Domain\Query\QueryHandlerInterface;
use Shabanov\Otusphp\Infrastructure\Db\ConnectionInterface;
use Exception;

class EsQueryHandler implements QueryHandlerInterface
{
    private Client $connection;
    private string $dbName;
    private const FILE_BOOKS = __DIR__ . '/../../../books.json';

    /**
     * @throws Exception
     */
    public function __construct(ConnectionInterface $connection, string $dbName)
    {
        $this->connection = $connection->getClient();
        $this->dbName = $dbName;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        if ($this->createIndex()) {
            $this->createDataFromFile();
        }
    }

    /**
     * @throws \Exception
     */
    private function createIndex(): bool
    {
        try {
            $response = $this->connection->indices()->create([
                'index' => $this->dbName,
                'body' => $this->mapping(),
            ]);
            return $response['acknowledged'];
        } catch (ElasticsearchException $e) {
            throw new \Exception('Error create Index: ' . $e->getMessage());
        }
        return false;
    }

    /**
     * @throws Exception
     */
    private function createDataFromFile(): void
    {
        try {
            $data = file_get_contents(self::FILE_BOOKS);
            if (!empty($data)) {
                $params = [
                    'body' => $data
                ];
                $this->connection->bulk($params);
            }
        } catch (ElasticsearchException $e) {
            throw new Exception('Error create Data in Index: ' . $e->getMessage());
        }
    }

    private function mapping(): array
    {
        return [
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
                            'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                        ]
                    ]
                ]
            ],
            'mappings' => [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => [
                    'title' => [
                        'type' => 'text'
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
                            'shop' => ['type' => 'text'],
                            'stock' => ['type' => 'integer']
                        ]
                    ]
                ]
            ]
        ];
    }
}
