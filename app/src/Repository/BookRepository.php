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
        $textFields = ['title', 'category'];
        $numericFields = ['price'];
        $numericObjectFields = ['stock.stock']; // New array for numeric fields that are nested inside an object
        $should = [];

        foreach ($params as $field => $value) {
            if (empty($value)) {
                continue;
            }

            if (in_array($field, $textFields)) {
                // Use fuzzy match for text fields
                $should[] = [
                    'match' => [
                        $field => [
                            'query'     => $value,
                            'fuzziness' => 'AUTO',
                        ]
                    ]
                ];
            } elseif (in_array($field, $numericFields)) {
                if (is_array($value)) {
                    $range = [];

                    if (isset($value['gte'])) {
                        $range['gte'] = $value['gte'];
                    }

                    if (isset($value['lte'])) {
                        $range['lte'] = $value['lte'];
                    }

                    $should[] = [
                        'range' => [
                            $field => $range
                        ]
                    ];
                } else {
                    // If $value is not an array, use a match query
                    $should[] = [
                        'match' => [
                            $field => $value
                        ]
                    ];
                }
            } elseif (in_array($field, $numericObjectFields)) { // New condition block for numeric fields that are nested inside an object
                if (is_array($value)) {
                    $range = [];

                    if (isset($value['gte'])) {
                        $range['gte'] = $value['gte'];
                    }

                    if (isset($value['lte'])) {
                        $range['lte'] = $value['lte'];
                    }

                    $should[] = [
                        'range' => [
                            $field => $range
                        ]
                    ];
                }
            }
        }


        if (empty($should)) {
            return [];
        }

        $params = [
            'index' => 'books',
            'body'  => [
                'query' => [
                    'bool' => [
                        'should' => $should,
                        'minimum_should_match' => 1
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);

        $books = [];
        foreach ($response['hits']['hits'] as $hit) {
            $source = $hit['_source'];

            // Flatten stock array into a string
            $stockString = '';
            foreach ($source['stock'] as $stockItem) {
                $stockString .= sprintf("%s: %d; ", $stockItem['shop'], $stockItem['stock']);
            }

            $books[] = new Book(
                $hit['_id'],
                $source['title'],
                $source['category'],
                $source['price'],
                rtrim($stockString, '; ')
            );
        }

        return $books;
    }
}