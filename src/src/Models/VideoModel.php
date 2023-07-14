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
}
