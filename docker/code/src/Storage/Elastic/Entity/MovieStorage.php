<?php

namespace IilyukDmitryi\App\Storage\Elastic\Entity;

use IilyukDmitryi\App\Storage\Base\MovieStorageInterface as MovieStorageInterfaceAlias;
use stdClass;

class MovieStorage extends Base implements MovieStorageInterfaceAlias
{
    public static function getIndexName(): string
    {
        return "youtube_movie";
    }

    public function getLikesDislikesFromChannels(int $cnt = 10): array
    {
        $params = [
            'size' => 0,
            'query' => [
                'match_all' => new stdClass()
            ],
            'aggs' => [
                'channels' => [
                    'terms' => [
                        'field' => 'channel_id',
                        'size' => $cnt
                    ],
                    'aggs' => [
                        'total_likes' => [
                            'sum' => [
                                'field' => 'like'
                            ]
                        ],
                        'total_dislikes' => [
                            'sum' => [
                                'field' => 'dislike'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->search($params, 10000);


        $arrResult = [];
        if (isset($response['aggregations']['channels']['buckets'])) {
            $topChannels = $response['aggregations']['channels']['buckets'];
            foreach ($topChannels as $channel) {
                $arrResult[] = [
                    'channel_id' => $channel['key'],
                    'likes' => $channel['total_likes']['value'],
                    'dislikes' => $channel['total_dislikes']['value'],
                ];
            }
        }

        return $arrResult;
    }

    public function getTopPopularChannels(int $cntTop = 10): array
    {
        $params = [
            'query' => [
                'match_all' => new stdClass()
            ],
            'aggs' => [
                'channels' => [
                    'terms' => [
                        'field' => 'channel_id',
                        'size' => 10000
                    ],
                    'aggs' => [
                        'likes' => [
                            'sum' => [
                                'field' => 'like'
                            ]
                        ],
                        'dislikes' => [
                            'sum' => [
                                'field' => 'dislike'
                            ]
                        ],
                        'likes_to_dislikes_ratio' => [
                            'bucket_script' => [
                                'buckets_path' => [
                                    'likes' => 'likes',
                                    'dislikes' => 'dislikes'
                                ],
                                'script' => 'params.likes / (params.likes + params.dislikes)'
                            ]
                        ],
                        'top_channels' => [
                            'bucket_sort' => [
                                'sort' => [
                                    'likes_to_dislikes_ratio' => [
                                        'order' => 'desc'
                                    ]
                                ],
                                'size' => $cntTop
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->search($params, 10000);

        $arrResult = [];
        if (isset($response['aggregations']['channels']['buckets'])) {
            $topChannels = $response['aggregations']['channels']['buckets'];

            foreach ($topChannels as $channel) {
                $arrResult[] = [
                    'channel_id' => $channel['key'],
                    'likes' => $channel['likes']['value'],
                    'dislikes' => $channel['dislikes']['value'],
                    'ratio' => $channel['likes_to_dislikes_ratio']['value'],
                ];
            }
        }
        return $arrResult;
    }

    protected function getSettings(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_',
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian',
                    ]
                ],
                'analyzer' => [
                    'my_russian' => [
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'ru_stop', 'ru_stemmer']
                    ]
                ]
            ],
        ];
    }

    protected function getMappings(): array
    {
        return [
            'properties' => [
                "movie_id" => [
                    "type" => "keyword"
                ],
                "channel_id" => [
                    "type" => "keyword"
                ],
                'movie_name' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'movie_description' => [
                    'type' => 'text',
                    'analyzer' => 'my_russian'
                ],
                'like' => [
                    'type' => 'integer'
                ],
                'dislike' => [
                    'type' => 'integer'
                ],
                'duration' => [
                    'type' => 'integer'
                ],
            ]
        ];
    }
}
