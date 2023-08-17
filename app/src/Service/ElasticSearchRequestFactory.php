<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\BookSearchDto;

final class ElasticSearchRequestFactory
{
    public function createBody(BookSearchDto $searchDto): array
    {
        $body = [
            'query' => [
                'bool' => [
                    'must' => [],
                ],
            ],
        ];

        if ($searchDto->sku !== null) {
            $body['query']['bool']['must'][] = ['term' => ['sku' => $searchDto->sku]];
        }

        if ($searchDto->title !== null) {
            $body['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $searchDto->title,
                        'fuzziness' => 'auto'
                    ]
                ]
            ];
        }

        if ($searchDto->categories !== null && count($searchDto->categories) > 0) {
            $categories = [];
            foreach ($searchDto->categories as $category) {
                $categories[] = ['term' => ['category' => $category]];
            }
            $body['query']['bool']['must'][] = ['bool' => ['should' => $categories]];
        }

        if ($searchDto->minPrice !== null || $searchDto->maxPrice !== null) {
            $priceRange = ['range' => ['price' => []]];
            if ($searchDto->minPrice !== null) {
                $priceRange['range']['price']['gte'] = $searchDto->minPrice;
            }
            if ($searchDto->maxPrice !== null) {
                $priceRange['range']['price']['lte'] = $searchDto->maxPrice;
            }

            $body['query']['bool']['must'][] = $priceRange;
        }

        if ($searchDto->shops !== null && count($searchDto->shops) > 0) {
            $stockShops = [];
            foreach ($searchDto->shops as $shop) {
                $stockShops[] = ['match' => ['stock.shop' => $shop]];
            }

            $body['query']['bool']['must'][] = [
                'nested' => [
                    'path' => 'stock',
                    "query" => [
                        "bool" => [
                            "must" => [
                                [
                                    'bool' => [
                                        'should' => $stockShops
                                    ]
                                ],
                                [
                                    'bool' => [
                                        'must' => [
                                            ['range' => ['stock.stock' => ['gte' => 0]]]
                                        ]
                                    ]
                                ],
                            ],

                        ]
                    ]
                ]
            ];
        }

        return $body;
    }

    public function createSettings(BookSearchDto $searchDto): ?array
    {
        if ($searchDto->title !== null) {
            return [
                'analyzer' => [
                    'my_russian' => [
                        "filter" => ["lowercase", "ru_stop", "ru_stemmer"]
                    ]
                ]
            ];
        }

        return null;
    }
}