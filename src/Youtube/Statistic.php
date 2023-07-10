<?php

declare(strict_types=1);

namespace Otus\App\Youtube;

use Otus\App\Elastic\Client;

final class Statistic
{
    public function __construct(
        private Client $client,
    ) {
    }

    public function topChannels(int $size): array
    {
        $params = [
            'size' => $size,
            'sort' => [
                [
                    '_script' => [
                        'type' => 'number',
                        'script' => [
                            'source' => "params['_source']['likeCount'] / params['_source']['dislikeCount']"
                        ],
                        'order' => 'desc'
                    ]
                ]
            ]
        ];


        $response = $this->client->search('youtube-videos', $params);

        return $response['hits']['hits'];
    }

    public function sumOfLikesAndDislikes(string $channelId): array
    {
        $params = [
            'size' => 0,
            'query' => [
                'term' => [
                    'channelId' => [
                        "value" => "$channelId",
                    ],
                ],
            ],
            'aggs' => [
                'likes' => [
                    'stats' => [
                        'field' => 'likeCount'
                    ]
                ],
                'dislikes' => [
                    'stats' => [
                        'field' => 'dislikeCount'
                    ]
                ]
            ]
        ];


        $response = $this->client->search('youtube-videos', $params);

        return $response['aggregations'];
    }
}