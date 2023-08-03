<?php

declare(strict_types=1);

namespace VLebedev\BookShop\Service\ElasticService;

class ElasticQueryBuilder
{
    public function buildCreateIndex(string $index, array $mapping): array
    {
        return [
            'index' => $index,
            'body' => [
                'mappings' => [
                    'properties' => $mapping
                ]
            ]
        ];
    }

    public function buildGetQuery(string $index, string $id): array
    {
        return [
            'index' => $index,
            'id' => $id
        ];
    }

    public function buildSearchQuery(
        string $index,
        array $filter = [],
        array $must = [],
        array $should = [],
    ): array {
        $body = [];

        foreach ($filter as $key => $value) {
            $body['query']['bool']['filter'][] = [$key => $value];
        }

        foreach ($must as $key => $value) {
            $body['query']['bool']['must'][$key] = $value;
        }

        foreach ($should as $key => $value) {
            $body['query']['bool']['should'][$key] = $value;
        }

        return [
            'index' => $index,
            'body' => $body
        ];
    }
}
