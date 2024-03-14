<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Infrastructure;

use AYamaliev\hw11\Application\Dto\SearchDto;

class ElasticSearchQuery
{
    public function __construct(private string $indexName, private SearchDto $searchDto)
    {
    }

    public function __invoke(): array
    {
        $subQuery['filter'][] = [
            'nested' => [
                'path' => 'stock',
                'query' => [
                    'bool' => [
                        'filter' => [
                            [
                                'range' => [
                                    'stock.stock' => ['gte' => 1]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        if ($this->searchDto->getTitle()) {
            $subQuery['must'][] = [
                'match' => [
                    'title' => [
                        "query" => $this->searchDto->getTitle(),
                        'fuzziness' => "auto"
                    ]
                ],
            ];
        }

        if ($this->searchDto->getCategory()) {
            $subQuery['must'][] = [
                'match' => [
                    'category' => [
                        "query" => $this->searchDto->getCategory(),
                        'fuzziness' => "auto"
                    ]
                ],
            ];
        }

        if ($this->searchDto->getPrice() && $this->searchDto->getCompareSign()) {
            $subQuery['filter'][] = [
                'range' => [
                    'price' => [$this->searchDto->getCompareSign() => $this->searchDto->getPrice()]
                ]
            ];
        }

        return [
            'index' => $this->indexName,
            'size' => 20,
            'body' => [
                'query' => [
                    'bool' => $subQuery
                ]
            ]
        ];
    }
}
