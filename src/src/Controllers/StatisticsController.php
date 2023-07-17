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
        $this->channelModel = new ChannelModel($esClient);
        $this->videoModel = new VideoModel($esClient);
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
        return $this->videoModel->getTotalLikes($channelId);
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
        return $this->videoModel->getTotalDislikes($channelId);
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
        return $this->channelModel->topChannels($vars['n']);
    }
}
