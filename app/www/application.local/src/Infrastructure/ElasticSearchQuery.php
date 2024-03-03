<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Infrastructure;

class ElasticSearchQuery
{
    public function __construct(private string $indexName, private ?array $arguments)
    {
    }

    public function __invoke(): array
    {
        $_title = null;
        $_category = null;
        $_compareSign = null;
        $_price = null;

        foreach ($this->arguments as $argument) {
            [$argumentName, $argumentValue] = explode('=', $argument);

            switch ($argumentName) {
                case '--title':
                    $_title = $argumentValue;
                    break;
                case '--category':
                    $_category = $argumentValue;
                    break;
                case '--price':
                    [$_compareSign, $_price] = explode(' ', $argumentValue);
                    $_price = (int)$_price;
            }
        }

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

        if ($_title) {
            $subQuery['must'][] = [
                'match' => [
                    'title' => [
                        "query" => $_title,
                        'fuzziness' => "auto"
                    ]
                ],
            ];
        }

        if ($_category) {
            $subQuery['must'][] = [
                'match' => [
                    'category' => [
                        "query" => $_category,
                        'fuzziness' => "auto"
                    ]
                ],
            ];
        }

        if ($_price && $_compareSign) {
            $subQuery['filter'][] = [
                'range' => [
                    'price' => [$_compareSign => $_price]
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