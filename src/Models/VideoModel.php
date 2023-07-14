<?php

namespace App\Models;

use Elasticsearch\Client;

class VideoModel
{
    private $esClient;
    private $index = 'videos';

    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    public function addVideo($videoData)
    {
        $params = [
            'index' => $this->index,
            'body'  => $videoData,
        ];

        $response = $this->esClient->index($params);

        return $response['result'];
    }

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
