<?php

declare(strict_types=1);

namespace App\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use JsonException;
use RuntimeException;

final class CreateIndex
{
    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function __construct(
        private readonly Client $client,
        private readonly string $index,
    )
    {
        $this->reCreateIndex($this->index);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function reCreateIndex(string $index): void
    {
        $params = [
            'index' => $index
        ];

        $result = $this->client->indices()->exists($params);
        if ($result && $result->asBool()) {
            $this->client->indices()->delete($params);
        }

        $this->client->indices()->create([
            'index' => $index
        ]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws JsonException
     */
    public function indexFromFile(string $file): void
    {
        if (!file_exists($file)) {
            throw new RuntimeException('File is not found. ' . $file);
        }

        $params = [
            'body' => [],
            'index' => $this->index,
            'client' => [
                'future' => 'lazy'
            ]
        ];

        $f = fopen($file, 'rb');

        while (($line = fgets($f)) !== false) {
            $line = json_decode($line, true, 512, JSON_THROW_ON_ERROR);
            if (isset($line['title'])) {
                $params['body'][] = $line;
            } else {
                $params['body'][] = [
                    'index' => [
                        '_id' => (string)$line['create']['_id']
                    ]
                ];
            }
        }
        fclose($f);
        $this->client->bulk($params);
    }

}