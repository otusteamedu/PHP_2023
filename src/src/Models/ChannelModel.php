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
}
