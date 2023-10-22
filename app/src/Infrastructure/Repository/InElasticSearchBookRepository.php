<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Book;
use App\Domain\Repository\BookRepositoryInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;

class InElasticSearchBookRepository implements BookRepositoryInterface
{
    public Client $client;

    private string $index;

    /** @var string[] */
    private const OPERATIONS = [
        '>=' => 'gte',
        '<=' => 'lte'
    ];

    /**
     * @throws Exception
     */
    public function __construct(string $url, string $user, string $password, string $index)
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$url])
            ->setBasicAuthentication($user, $password)
            ->build();
        $this->index = $index;
    }

    /**
     * @throws Exception
     */
    public function searchByTitle(string $title): array
    {
        return $this->search(self::queryByTitle($title));
    }

    /**
     * @throws Exception
     */
    public function searchByTitleCategory(string $title, string $category): array
    {
        return $this->search(self::queryByTitleCategory($title, $category));
    }

    /**
     * @throws Exception
     */
    public function searchByTitleCategoryPrice(string $title, string $category, string $price): array
    {
        return $this->search(self::queryByTitleCategoryPrice($title, $category, $price));
    }

    /**
     * @throws Exception
     */
    public function searchByTitleCategoryPriceAvailability(string $title, string $category, string $price): array
    {
        return $this->search(self::queryByTitleCategoryPriceAvailability($title, $category, $price));
    }

    /**
     * @throws Exception
     */
    private function search($query): array
    {
        $params = [
            'index' => $this->index,
            'body'  => []
        ];

        $params['body']['query'] = $query;
        $results = $this->client->search($params)->asArray();

        if (!empty($results['hits']['hits'])) {
            $results = array_map(function ($item) {
                return $item['_source'];
            }, $results['hits']['hits']);
        } else {
            $results = [];
        }

        return $this->modifyResult($results);
    }

    private static function queryByTitle(string $title): array
    {
        return [
            "match" => [
                "title" => [
                    "query" => $title,
                    "fuzziness" => "auto"
                ]
            ]
        ];
    }

    private static function queryByTitleCategory(string $title, string $category): array
    {
        return [
            "bool" => [
                "must" => [
                    self::queryByTitle($title)
                ],
                "filter" => [
                    "term" => [
                        "category" => $category
                    ]
                ]
            ]
        ];
    }

    private static function queryByTitleCategoryPrice(string $title, string $category, string $price): array
    {
        $operation = self::OPERATIONS[substr($price, 0, 2)];

        return [
            "bool" => [
                "must" => [
                    self::queryByTitle($title)
                ],
                "filter" => [
                    [
                        "term" => [
                            "category" => $category
                        ]
                    ],
                    [
                        "range" => [
                            "price" => [
                                $operation => substr($price, 2)
                            ]
                        ]
                    ]

                ]
            ]
        ];
    }

    private static function queryByTitleCategoryPriceAvailability(string $title, string $category, string $price): array
    {
        $result = self::queryByTitleCategoryPrice($title, $category, $price);
        $result['bool']['filter'][] = [
            "nested" => [
                "path" => "stock",
                "query" => [
                    "range" => [
                        "stock.stock" => [
                            "gte" => 1
                        ]
                    ]
                ]
            ]
        ];

        return $result;
    }

    private function modifyResult(array $result): array
    {
        foreach ($result as &$item) {
            $book = new Book($item['sku'], $item['sku'], $item['category'], $item['price'], $item['stock']);
            $item = $book;
        }

        return $result;
    }
}
