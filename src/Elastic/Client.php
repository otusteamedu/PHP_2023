<?php

declare(strict_types=1);

namespace Otus\App\Elastic;

use Elastic\Elasticsearch\Client as ElasticClient;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

final readonly class Client
{
    private ElasticClient $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['localhost:9200'])
            ->build();
    }

    public function version(): string
    {
        $response = $this->client->info();

        return $response['version']['number'];
    }

    public function bulk(string $index, array $values): void
    {
        $body = [];

        foreach ($values as $value) {
            if (array_key_exists('id', $value)) {
                $body[] = ['index' => ['_index' => $index, '_id' => $value['id']]];
                unset($value['id']);
            } else {
                $body[] = ['index' => ['_index' => $index]];
            }

            $body[] = $value;
        }

        $params = ['body' => $body];

        $this->client->bulk($params);
    }

    public function createIndex(string $index, array $fields): void
    {
        $params = [
            'index' => $index,
            'body' => [
                'mappings' => [
                    'properties' => $fields,
                ]
            ]
        ];

        $this->client->indices()->create($params);
    }

    public function addDoc(string $index, array $body): void
    {
        $params = [
            'index' => $index,
            'body' => $body,
        ];

        $this->client->index($params);
    }

    public function deleteDoc(string $index, string $id): void
    {
        $params = [
            'id' => $id,
            'index' => $index,
        ];

        $this->client->delete($params);
    }

    public function search(string $index, array $body): array
    {
        $params = [
            'index' => $index,
            'body' => $body
        ];

        $response = $this->client->search($params);

        return $response->asArray();
    }
}
