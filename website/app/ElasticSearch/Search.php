<?php

declare(strict_types=1);

namespace App\ElasticSearch;

final class Search
{
    public function __construct(
        private \Elastic\Elasticsearch\Client $client,
        private string $index,
    )
    {
    }

    public function search(string $query): array
    {
        $output = [];
        $result = $this->client->search($query);

        return $output;
    }
}