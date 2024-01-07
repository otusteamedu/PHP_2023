<?php

declare(strict_types=1);

namespace Models;

class BookStoreModel
{
    const INDEX_NAME = 'book-store';
    const FILE_NAME  = 'books.json';

    public static function getMappings(): array
    {
        return [
            'properties' => [
                'category' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256
                        ]
                    ]
                ],
                'price' => [
                    'type' => 'long'
                ],
                'sku'  => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256
                        ]
                    ]
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'text',
                            'fields' => [
                                'keyword' => [
                                    'type' => 'keyword',
                                    'ignore_above' => 256
                                ]
                            ]
                        ],
                        'stock' => [
                            'type' => 'long'
                        ]
                    ]
                ],
                'title' => [
                    'type' => 'text',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function getSettings(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => "_russian_"
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian'
                    ]
                ],
                "analyzer" => [
                    "my_russian" => [
                        'tokenizer' => 'standard',
                        'filter' => [
                            'lowercase',
                            'ru_stop',
                            'ru_stemmer'
                        ]
                    ]
                ]
            ]
        ];
    }
}
