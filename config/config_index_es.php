<?php

return [
    'index' => 'otus-shop',
    'body' => [
        'settings' => [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_'
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian'
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => [
                            'lowercase',
                            'ru_stop',
                            'ru_stemmer'
                        ]
                    ]
                ]

            ]
        ],
        'mappings' => [
            'properties' => [
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'sku' => [
                    'type' => 'text'
                ],
                'category' => [
                    'type' => 'keyword',
                ],
                'price' => [
                    'type' => 'short'
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'keyword',
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
