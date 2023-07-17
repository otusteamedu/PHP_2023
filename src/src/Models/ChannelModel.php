<?php

namespace App\Models;

use Elasticsearch\Client;

/**
 * Class ChannelModel
 *
 * @package App\Models
 */
class ChannelModel
{
    /**
     * @var Client
     */
    private $esClient;
    /**
     * @var string
     */
    private $index = 'channels';

    /**
     * ChannelModel constructor.
     *
     * @param Client $esClient
     */
    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    /**
     * Add a channel
     *
     * @param array $channelData
     *
     * @return string
     */
    public function addChannel($channelData)
    {
        $params = [
            'index' => $this->index,
            'body'  => $channelData,
        ];

        $response = $this->esClient->index($params);

        return $response['result'];
    }

    /**
     * Delete a channel
     *
     * @param int $channelId
     *
     * @return string
     */
    public function deleteChannel($channelId)
    {
        $params = [
            'index' => $this->index,
            'body'  => [
                'query' => [
                    'term' => [
                        'channel_id' => $channelId,
                    ],
                ],
            ],
        ];

        $response = $this->esClient->deleteByQuery($params);

        return $response['result'];
    }

    /**
     * Get the index name.
     *
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    public function topChannels($n)
    {
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
