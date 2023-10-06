<?php

namespace App;

use Elastic\Elasticsearch\{
    Client,
    Exception\ClientResponseException,
    Exception\ServerResponseException
};
use Exception;

class MyApp
{
    private Client $client;

    private string $index;

    /** @var string[]  */
    private const OPERATIONS = [
        '>=' => 'gte',
        '<=' => 'lte'
    ];

    public function __construct(Client $client, string $index) {
        $this->client = $client;
        $this->index = $index;
    }

    /**
     * @return array
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws Exception
     */
    public function search(): array
    {
        $args = $_SERVER['argv'];
        unset($args[0]);
        $countArgv = count($args);

        $params = [
            'index' => $this->index,
            'body'  => []
        ];

        $query = match ($countArgv) {
            // Поиск по title -> php public/index.php гроницы
            1 => $this->queryByTitle($args[1]),

            // Поиск по title и строгому соответствую категории category -> php public/index.php гроницы "Любовный роман"
            2 => $this->queryByTitleCategory($args[1], $args[2]),

            // Поиск по title, строгому соответствую категории category и ценой <=|>= указанной ->
            // php public/index.php гроницы "Любовный роман" \>=9700
            3 => $this->queryByTitleCategoryPrice($args[1], $args[2], $args[3]),

            // php public/index.php Штирлиц "Исторический роман" \>=700 1
            // последний аргумент может быть любым, говорит о том, чтобы товар был в наличии
            4 => $this->queryByTitleCategoryPriceAvailability($args[1], $args[2], $args[3]),

            default => throw new Exception("Incorrect args"),
        };

        $params['body']['query'] = $query;
        $results = $this->client->search($params)->asArray();

        if (!empty($results['hits']['hits'])) {
            $results = array_map(function ($item) {
                return $item['_source'];
            }, $results['hits']['hits']);
        } else {
            $results = [];
        }

        return $results;
    }

    private function queryByTitle(string $title): array
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

    private function queryByTitleCategory(string $title, string $category): array
    {
        return [
            "bool" => [
                "must" => [
                    $this->queryByTitle($title)
                ],
                "filter" => [
                    "term" => [
                        "category" => $category
                    ]
                ]
            ]
        ];
    }

    private function queryByTitleCategoryPrice(string $title, string $category, string $price): array
    {
        $operation = self::OPERATIONS[substr($price, 0, 2)];

        return [
            "bool" => [
                "must" => [
                    $this->queryByTitle($title)
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

    private function queryByTitleCategoryPriceAvailability(string $title, string $category, string $price): array
    {
        $result = $this->queryByTitleCategoryPrice($title, $category, $price);
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
}
