<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Database\ElasticsearchClient;
use App\Models\Book;

class BookRepository {
    private $client;
    private $index = 'books';

    public function __construct() {
        $this->client = (new ElasticsearchClient())->getClient();
    }

    public function indexBooks(array $books)
    {
        $params = ['body' => []];

        foreach ($books as $book) {
            $params['body'][] = [
                'create' => [
                    '_index' => $this->index,
                    '_id' => $book->getId(),
                ],
            ];

            $params['body'][] = [
                'title' => $book->getTitle(),
                'category' => $book->getCategory(),
                'price' => $book->getPrice(),
                'stock' => $book->getStock(),
            ];
        }

        $this->client->bulk($params);
    }

    public function searchBooks(array $params): array
    {
        $searchParams = [
            'index' => $this->index,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $params['query'],
                                'fields' => ['title^3', 'category'],
                                'fuzziness' => 'AUTO',
                            ],
                        ],
                        'filter' => [],
                    ],
                ],
            ],
        ];

        if (!empty($params['category'])) {
            $searchParams['body']['query']['bool']['filter'][] = [
                'term' => [
                    'category.keyword' => $params['category'],
                ],
            ];
        }

        if (!empty($params['max_price'])) {
            $searchParams['body']['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'lte' => $params['max_price'],
                    ],
                ],
            ];
        }

        $searchParams['body']['query']['bool']['filter'][] = [
            'range' => [
                'stock' => [
                    'gte' => 1,
                ],
            ],
        ];

        $response = $this->client->search($searchParams);

        $books = [];
        foreach ($response['hits']['hits'] as $hit) {
            $source = $hit['_source'];
            $books[] = new Book(
                $hit['_id'],
                $source['title'],
                $source['category'],
                $source['price'],
                $source['stock']
            );
        }

        return $books;
    }
}
