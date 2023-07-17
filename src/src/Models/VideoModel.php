<?php

namespace App\Models;

use Elasticsearch\Client;

/**
 * Class VideoModel
 *
 * @package App\Models
 */
class VideoModel
{
    /**
     * @var Client
     */
    private $esClient;
    /**
     * @var string
     */
    private $index = 'videos';

    /**
     * VideoModel constructor.
     *
     * @param Client $esClient
     */
    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    /**
     * Add a video
     *
     * @param array $videoData
     *
     * @return string
     */
    public function addVideo($videoData)
    {
        $params = [
            'index' => $this->index,
            'body'  => $videoData,
        ];

        $response = $this->esClient->index($params);

        return $response['result'];
    }

    /**
     * Delete a video.
     *
     * @param int $videoId
     *
     * @return string
     */
    public function deleteVideo($videoId)
    {
        $params = [
            'index' => $this->index,
            'body'  => [
                'query' => [
                    'term' => [
                        'video_id' => $videoId,
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

    /**
     * Get total likes for a channel.
     *
     * @param int $channelId
     *
     * @return mixed
     */
    public function getTotalLikes(int $channelId)
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
     * Get total dislikes for a channel.
     *
     * @param int $channelId
     *
     * @return mixed
     */
    public function getTotalDislikes(int $channelId)
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
}
