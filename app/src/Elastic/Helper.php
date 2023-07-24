<?php

declare(strict_types=1);

namespace Desaulenko\Hw11\Elastic;

class Helper
{
    /**
     * @param string $q
     * @param int $priceFrom
     * @param int $stock
     * @return array[]
     */
    public static function makeBodySearch(string $q, int $priceFrom, int $stock = 1): array
    {
        return [
            'query' => [
                'bool' => [
                    'must' => [
                        [
                            'match' => [
                                'title' => [
                                    'query' => $q,
                                    'fuzziness' => 'auto'
                                ]
                            ]
                        ],
                        [
                            'nested' => [
                                'path' => 'stock',
                                'query' => [
                                    'bool' => [
                                        'must' => [
                                            [
                                                'range' => [
                                                    'stock.stock' => [
                                                        'gte' => $stock
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'filter' => [
                        [
                            'range' => [
                                'price' => [
                                    'gte' => $priceFrom
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ];
    }

    /**
     * @param array $input
     * @return void
     */
    public static function printResult(array $input): void
    {
        if ($input['hits']['total']['value'] <= 0) {
            echo 'No result found';
            return;
        }

        $result = [];
        $maxLength = [];
        foreach ($input['hits']['hits'] as $hit) {
            foreach ($hit['_source'] as $key => $item) {
                if ($key !== 'stock') {
                    $result[$hit['_id']][$key] = trim((string)$item);
                    $maxLength[$key] = strlen((string)$item) > $maxLength[$key] ? strlen((string)$item) : $maxLength[$key];
                    continue;
                }
                foreach ($item as $stock) {
                    $key = 'shop_stock';
                    $value = $stock['shop'] . ' = ' . $stock['stock'];
                    $result[$hit['_id']][$key][] = $value;
                    $maxLength[$key] = strlen($value) > $maxLength[$key] ? strlen($value) : $maxLength[$key];
                }
            }
        }
        
        foreach ($result as $row) {
            foreach ($row as $key => $item) {
                if (!is_array($item)) {
                    printf("%-{$maxLength[$key]}s | ", $item);
                    continue;
                }
                foreach ($item as $val) {
                    printf("%-{$maxLength[$key]}s | ", $val);
                }
            }
            echo PHP_EOL;
        }
    }
}
