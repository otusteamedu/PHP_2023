<?php

namespace HW11\Elastic;

class SearchExecutor extends AbstractElasticSearch
{
    protected array $searchParams;
    public function __construct(
        string $host,
        string $user,
        string $password,
    ) {
        parent::__construct($host, $user, $password);
        $this->searchParams = [
            'index' => self::INDEX_NAME,
            'from'  => 0,
            'size'  => 10,
            'body'  => [
                'query' => [
                    'bool' => [
                        'must'   => [],
                        'filter' => [
                            [
                                'nested' => [
                                    'path'  => 'stock',
                                    'query' => [
                                        'bool' => [
                                            'must' => [],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
    private function setCategory(string $category): void
    {
        $this->searchParams['body']['query']['bool']['filter'][] = [
            'match' => [
                'category' => $category,
            ],
        ];
    }
    public function setTitle(string $title): void
    {
        $this->searchParams['body']['query']['bool']['must'] = [
            'match' => [
                'title' => [
                    'query'     => $title,
                    'fuzziness' => 'auto',
                    'operator'  => 'and',
                ],
            ],
        ];
    }
    private function setPrice(string $price): void
    {
        $price = $this->transformCompareOperators($price);
        $this->searchParams['body']['query']['bool']['filter'][] = [
            'range' => [
                'price' => $price,
            ],
        ];
    }
    private function transformCompareOperators(string $string): array
    {
        $digit = str_replace(['>', '<', '='], '', $string);
        if (str_contains($string, '<=')) {
            return ['lte' => $digit];
        }
        if (str_contains($string, '>=')) {
            return ['gte' => $digit];
        }
        if (str_contains($string, '<')) {
            return ['lt' => $digit];
        }
        if (str_contains($string, '>')) {
            return ['gt' => $digit];
        }
        return [
            'lte' => $digit,
            'gte' => $digit,
        ];
    }
    private function setStock(string $count): void
    {
        $this->searchParams['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
            'range' => [
                'stock.stock' => $count,
            ],
        ];
    }
    public function search(array $commands)
    {
        if (array_key_exists('title', $commands)) {
            $this->setTitle($commands['title']);
        }
        if (array_key_exists('category', $commands)) {
            $this->setCategory($commands['category']);
        }
        if (array_key_exists('price', $commands)) {
            $this->setPrice($commands['price']);
        }
        if (array_key_exists('stock', $commands)) {
            $this->setStock($commands['stock']);
        }
        return $this->client->search($this->searchParams);
    }
}
