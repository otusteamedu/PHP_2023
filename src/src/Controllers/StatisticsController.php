<?php

namespace App\Controllers;

use Elasticsearch\Client;
use App\Models\ChannelModel as ChannelModel;
use App\Models\VideoModel as VideoModel;

/**
 * Class StatisticsController
 *
 * @package App\Controllers
 */
class StatisticsController
{
    /**
     * @var Client
     */
    private $esClient;
    /**
     * @var ChannelModel
     */
    private $channelModel;
    /**
     * @var VideoModel
     */
    private $videoModel;

    /**
     * StatisticsController constructor.
     *
     * @param Client $esClient
     */
    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
        //$this->channelModel = new ChannelModel($esClient);
        //$this->videoModel = new VideoModel($esClient);
    }

    /**
     * Get total likes and dislikes for a channel
     *
     * @param mixed $vars
     *
     * @return array
     */
    public function showStatistics($vars)
    {
        $channelId = $vars['channelId'];

        $totalLikes = $this->getTotalLikes($channelId);
        $totalDislikes = $this->getTotalDislikes($channelId);

        return [
            'channel_id' => $channelId,
            'total_likes' => $totalLikes,
            'total_dislikes' => $totalDislikes,
        ];
    }

    /**
     * Get top N channels by likes to dislikes ratio
     *
     * @param int $channelId
     *
     * @return array
     */
    private function getTotalLikes($channelId)
    {
        $params = [
            'index' => 'videos',
            'body' => [
                'query' => [
                    'term' => ['channel_id' => $channelId],
                ],
                'aggs' => [
                    'total_likes' => [
                        'sum' => ['field' => 'likes'],
                    ],
                ],
            ],
        ];

        $response = $this->esClient->search($params);

        return $response['aggregations']['total_likes']['value'] ?? 0;
    }

    /**
     * Get total dislikes for a channel
     *
     * @param int $channelId
     *
     * @return array
     */
    private function getTotalDislikes($channelId)
    {
        $params = [
            'index' => 'videos',
            'body' => [
                'query' => [
                    'term' => ['channel_id' => $channelId],
                ],
                'aggs' => [
                    'total_dislikes' => [
                        'sum' => ['field' => 'dislikes'],
                    ],
                ],
            ],
        ];

        $response = $this->esClient->search($params);

        return $response['aggregations']['total_dislikes']['value'] ?? 0;
    }
    /**
     * Get top channels by likes to dislikes ratio
     *
     * @param array $vars
     *
     * @return array
     */
    public function topChannels($vars)
    {
        $n = $vars['n'];
        $params = [
            'index' => 'videos',
            'body' => [
                'size' => 0,
                'aggs' => [
                    'top_channels' => [
                        'terms' => [
                            'field' => 'channel_id',
                            'size' => $n,
                            'order' => [
                                'total_likes' => 'desc'
                            ]
                        ],
                        'aggs' => [
                            'total_likes' => [
                                'sum' => [
                                    'field' => 'likes'
                                ]
                            ],
                            'total_dislikes' => [
                                'sum' => [
                                    'field' => 'dislikes'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $response = $this->esClient->search($params);

        $topChannels = [];
        foreach ($response['aggregations']['top_channels']['buckets'] as $bucket) {
            $channelId = $bucket['key'];
            $totalLikes = $bucket['total_likes']['value'];
            $totalDislikes = $bucket['total_dislikes']['value'];

            $topChannels[] = [
                'channel_id' => $channelId,
                'total_likes' => $totalLikes,
                'total_dislikes' => $totalDislikes,
            ];
        }
        return $topChannels;
    }
}
