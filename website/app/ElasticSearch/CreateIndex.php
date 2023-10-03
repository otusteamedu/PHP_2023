<?php

declare(strict_types=1);

namespace App\ElasticSearch;

final class CreateIndex
{
    public function __construct(
        private \Elastic\Elasticsearch\Client $client,
        private string $index,
    )
    {
        $this->reCreateIndex($this->index);
    }

    public function reCreateIndex(string $index): void
    {
        $params = [
            'index' => $index
        ];

        $result = $this->client->indices()->exists($params);
        if ($result && $result->asBool()){
            $this->client->indices()->delete($params);
        }

        $this->client->indices()->create([
            'index' => $index
        ]);
    }

    public function indexFromFile(string $file): void
    {
        if (!file_exists($file)) {
            throw new \RuntimeException('File is not found. ' . $file);
        }

        $data = json_decode(file_get_contents($file));
    }

}