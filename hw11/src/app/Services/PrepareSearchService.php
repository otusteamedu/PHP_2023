<?php

declare(strict_types=1);

namespace App\Services;

class PrepareSearchService
{
    private const OPERATORS = [
        '>' => 'gt',
        '>=' => 'gte',
        '<' => 'lt',
        '<=' => 'lte',
    ];

    public static function getSearchParams(): array|bool
    {
        $params = $_SERVER['argv'];

        if (count($params) > 1) {
            unset($params[0]);

            $searchParams = [];

            foreach ($params as $param) {
                [$paramKey, $paramValue] = explode(':', $param);

                if ($paramKey === 'title') {
                    $value = [
                        'query' => $paramValue,
                        'fuzziness' => 'auto',
                    ];
                } elseif ($paramKey === 'category') {
                    $value = $paramValue;
                } else {
                    $value = self::getValue($paramValue);
                }

                if (($paramKey === 'price' || $paramKey === 'stock') && is_array($value)) {
                    $key = 'range';
                    $filter = 'filter';

                    if ($paramKey === 'stock') {
                        $paramKey = 'stock.stock';
                    }
                } elseif ($paramKey === 'category') {
                    $key = 'term';
                    $filter = 'must';
                    $paramKey = 'category';
                } else {
                    $key = 'match';
                    $filter = 'must';
                }

                if (!array_key_exists($filter, $searchParams)) {
                    $searchParams[$filter] = [];
                }

                if (count($searchParams[$filter]) === 0) {
                    $searchParams[$filter][] = [$key => [$paramKey => $value]];
                } else {
                    foreach ($searchParams[$filter] as $existKey => $existFilter) {
                        if (!array_key_exists($key, $existFilter)) {
                            $searchParams[$filter][] = [$key => [$paramKey => $value]];
                        } else {
                            if (!array_key_exists($paramKey, $existFilter[$key])) {
                                $searchParams[$filter][][$key] = [$paramKey => $value];
                            } else {
                                if (is_array($searchParams[$filter][$existKey][$key][$paramKey])) {
                                    $searchParams[$filter][$existKey][$key][$paramKey] = array_merge(
                                        $searchParams[$filter][$existKey][$key][$paramKey],
                                        $value
                                    );
                                } else {
                                    $searchParams[$filter][$existKey][$key][$paramKey] = $value;
                                }
                            }
                        }
                    }
                }
            }

            return $searchParams;
        }

        return false;
    }

    private static function getValue(string $value): array|string
    {
        $array = explode(' ', $value);

        if (count($array) > 1) {
            $array[0] = array_key_exists($array[0], self::OPERATORS) ? self::OPERATORS[$array[0]] : $array[0];

            return [$array[0] => $array[1]];
        }

        return $array[0];
    }
}
