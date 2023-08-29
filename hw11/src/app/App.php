<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class App
{
    private const ELASTIC_HOST = 'es:9200';
    private const ELASTIC_USERNAME = 'elastic';
    private const ELASTIC_PASSWORD = 'elastic_password';
    private const ELASTIC_INDEX = 'books-shop';
    private const ELASTIC_MAX_OUTPUT_SIZE = 100;

    private array $operators = [
        '>' => 'gt',
        '>=' => 'gte',
        '<' => 'lt',
        '<=' => 'lte',
    ];

    private Client $client;

    public function __construct()
    {
        $client = ClientBuilder::create()
            ->setHosts([self::ELASTIC_HOST])
            ->setBasicAuthentication(self::ELASTIC_USERNAME, self::ELASTIC_PASSWORD)
            ->build();

        $this->client = $client;
    }

    public function get(): void
    {
        $searchParams = $this->getSearchParams();

        $params = [
            'index' => self::ELASTIC_INDEX,
            'size' => self::ELASTIC_MAX_OUTPUT_SIZE,
            'body' => [
                'sort' => [
                    "_score" => "desc"
                ],
                'query' => [
                    "bool" => $searchParams
                ]
            ]
        ];

        try {
            $result = $this->client->search($params);
        } catch (ClientResponseException|ServerResponseException $e) {
            echo $e->getResponse() . PHP_EOL;
        }

        if (isset($result) && isset($result['hits']) && isset($result['hits']['hits'])) {
            $items = array_map(function ($item) {
                return $item['_source'];
            }, $result['hits']['hits']);

            $this->outputResult($items);
        }
    }

    private function outputResult(array $items): void
    {
        foreach ($items as $i => $lines) {
            foreach ($lines as $key => $value) {
                if (!is_array($value)) {
                    $columns[$key][0] = $key;
                    $columns[$key][] = $value;

                    $rows[$i][] = $value;
                } else {
                    foreach ($value as $subKey => $subValue) {
                        $complexKey = $key . ' (' . $subValue['shop'] . ')';
                        $columns[$complexKey][0] = $complexKey;
                        $columns[$complexKey][] = $subValue['stock'];

                        $rows[$i][] = $subValue['stock'];
                    }
                }
            }
        }

        $rows = [[...array_keys($columns)], ...$rows];
        $lengths = array_values(array_map(fn($x) => max(array_map('mb_strlen', $x)), $columns));

        foreach ($rows as $row) {
            foreach ($row as $key => $data) {
                $string = (is_bool($data)) ? (($data) ? 'true' : 'false') : (string)$data;

                $lengthDelta = $lengths[$key] - mb_strlen($string, 'UTF-8');
                for ($i = 0; $i < $lengthDelta; $i++) {
                    $string .= ' ';
                }
                $string .= ' | ';

                echo $string;
            }
            echo PHP_EOL;
        }
    }

    private function getSearchParams(): array|bool
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
                    $value = $this->getValue($paramValue);
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

    private function getValue(string $value): array|string
    {
        $array = explode(' ', $value);

        if (count($array) > 1) {
            $array[0] = array_key_exists($array[0], $this->operators) ? $this->operators[$array[0]] : $array[0];

            return [$array[0] => $array[1]];
        }

        return $array[0];
    }

    public function create(): void
    {
        $params = [
            'index' => self::ELASTIC_INDEX,
            'body' => [
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'sku' => [
                            'type' => 'keyword'
                        ],
                        'category' => [
                            'type' => 'keyword'
                        ],
                        'price' => [
                            'type' => 'short'
                        ],
                        'stock' => [
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword'
                                ],
                                'stock' => [
                                    'type' => 'short'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $this->client->indices()->create($params);

        $handle = fopen(realpath(__DIR__ . '/..') . '/books.json', "r");
        if ($handle) {
            $data = ['body' => []];
            $i = 0;

            while (($line = fgets($handle)) !== false) {
                $i++;

                $data['body'][] = json_decode($line, true);

                if ($i % 1000 == 0) {
                    $this->client->bulk($data);
                    $data = ['body' => []];
                }
            }

            if (!empty($data['body'])) {
                $this->client->bulk($data);
            }

            fclose($handle);
        }
    }
}
