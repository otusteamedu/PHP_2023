<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Es;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ElasticsearchException;
use Exception;

class EsCreateIndex
{
    private Client $esConnection;
    private string $esIndexName;
    private const FILE_BOOKS = __DIR__ . '/../../books.json';

    /**
     * @throws Exception
     */
    public function __construct(EsConnection $esConnection, string $esIndexName)
    {
        $this->esConnection = $esConnection->getClient();
        $this->esIndexName = $esIndexName;
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
     * @throws Exception
     */
    private function createIndex(): ?bool
    {
        try {
            $response = $this->esConnection->indices()->create([
                'index' => $this->esIndexName,
                'body' => $this->mapping(),
            ]);
            return $response['acknowledged'];
        } catch (ElasticsearchException $e) {
            throw new Exception('Error create Index: ' . $e->getMessage());
        }
        return null;
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
                $this->esConnection->bulk($params);
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
