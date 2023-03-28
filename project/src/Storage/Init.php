<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Vp\App\Config;
use Vp\App\DTO\Message;
use Vp\App\DTO\StatusCode;
use Vp\App\Result\ResultInit;

class Init
{
    use StorageClient;

    private Client $client;
    private string $indexName;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = $this->getClient();
        $this->indexName = Config::getInstance()->getIndexName();
    }
    public function work(): ResultInit
    {
        $result = $this->deleteIndex();

        if (!$result->isSuccess()) {
            return $result;
        }

        $result = $this->createIndex();

        if (!$result->isSuccess()) {
            return $result;
        }

        return $this->indexBulk();
    }

    private function deleteIndex(): ResultInit
    {
        try {
            $this->client->indices()->delete(['index' => $this->indexName]);
        } catch (ClientResponseException $e) {
        } catch (MissingParameterException | ServerResponseException $e) {
            return new ResultInit(false, $e->getMessage());
        }

        return new ResultInit(true);
    }

    private function createIndex(): ResultInit
    {
        try {
            $response = $this->client->indices()->create([
                'index' => $this->indexName,
                'body' => [
                    'settings' => $this->getSettings(),
                    'mappings' => $this->getMappings()
                ]
            ]);

            if ($response->getStatusCode() !== StatusCode::STATUS_200) {
                return new ResultInit(false, sprintf(Message::FAILED_CREATE_INDEX, $this->indexName));
            }
        } catch (MissingParameterException | ServerResponseException | ClientResponseException $e) {
            return new ResultInit(false, $e->getMessage());
        }

        return new ResultInit(true);
    }

    private function indexBulk(): ResultInit
    {
        $json = file_get_contents(Config::getInstance()->getPath());
        try {
            $response = $this->client->bulk([
                'index' => $this->indexName,
                'body' => $json
            ]);

            if ($response->getStatusCode() !== StatusCode::STATUS_200) {
                return new ResultInit(false, sprintf(Message::FAILED_BULK_INDEX, $this->indexName));
            }
        } catch (ClientResponseException | ServerResponseException | MissingParameterException $e) {
            return new ResultInit(false, sprintf(
                Message::FAILED_BULK_INDEX, $this->indexName) . ': ' .$e->getMessage()
            );
        }

        return new ResultInit(true, sprintf(Message::CREATE_INDEX, $this->indexName));
    }

    private function getSettings(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_',
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian',
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                    ]
                ]
            ],
        ];
    }

    private function getMappings(): array
    {
        return [
            'properties' => [
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'category' => [
                    'type' => 'keyword'
                ],
                'sku' => [
                    'type' => 'keyword'
                ],
                'price' => [
                    'type' => 'short'
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'keyword'
                        ],
                        'stock' => [
                            'type' => 'short'
                        ],
                    ]
                ]
            ]
        ];
    }
}
