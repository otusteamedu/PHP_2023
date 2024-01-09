<?php

declare(strict_types=1);

namespace App\Service;

class ElasticQueryBuilder
{

    public function buildSearchQuery(string $index, array $filter = [], array $must = []): array
    {
        $body = [];

        foreach ($filter as $key => $value) {
            $body['query']['bool']['filter'][] = [$key => $value];
        }

        foreach ($must as $key => $value) {
            $body['query']['bool']['must'][$key] = $value;
        }

        return [
            'index' => $index,
            'body' => $body
        ];
    }
}
