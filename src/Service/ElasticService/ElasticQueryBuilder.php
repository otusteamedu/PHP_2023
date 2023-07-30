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
        string $category = null,
        int    $priceGte = null,
        int    $priceLte = null,
        string $title = null,
        int    $stock = null): array
    {
        $body = [];
        if ($category) {
            $body['query']['bool']['filter'][] = ['match' => ['category.keyword' => $category]];
        }
        $priceArr = [];
        if ($priceGte) {
            $priceArr['gte'] = $priceGte;
        }
        if ($priceLte) {
            $priceArr['lte'] = $priceLte;
        }
        if (count($priceArr)) {
            $body['query']['bool']['filter'][] = ['range' => ['price' => $priceArr]];
        }
        if ($title) {
            $body['query']['bool']['must']['match']['title']['query'] = $title;
            $body['query']['bool']['must']['match']['title']['fuzziness'] = 2;
        }
        if ($stock) {
            $body['query']['bool']['should']['range']['stock.stock']['gte'] = $stock;
            $body['query']['bool']['should']['range']['stock.stock']['lte'] = $stock;
        }
        return [
            'index' => $index,
            'body' => $body
        ];
    }
}
