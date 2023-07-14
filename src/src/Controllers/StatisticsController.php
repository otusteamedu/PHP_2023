<?php

namespace App\Controllers;

use App\Models\ChannelModel;
use App\Models\VideoModel;

/**
 * Class StatisticsController
 *
 * @package App\Controllers
 */
class StatisticsController
{
    /**
     * @var ChannelModel
     */
    private $channelModel;
    /**
     * @var VideoModel
     */
    private $videoModel;

    public function __construct(ChannelModel $channelModel, VideoModel $videoModel)
    {
        $this->channelModel = $channelModel;
        $this->videoModel = $videoModel;
    }

    /**
     * Get total likes and dislikes for a channel
     *
     * @param int $channelId
     *
     * @return array
     */
    public function getTotalLikesAndDislikesForChannel($channelId)
    {
        $channelData = $this->channelModel->getChannelData($channelId);
        $videosData = $this->videoModel->getVideosDataForChannel($channelId);

        $totalLikes = 0;
        $totalDislikes = 0;

        foreach ($videosData as $videoData) {
            $totalLikes += $videoData['likes'];
            $totalDislikes += $videoData['dislikes'];
        }

        return [
            'channel' => $channelData,
            'likes' => $totalLikes,
            'dislikes' => $totalDislikes,
        ];
    }

    /**
     * Get top N channels by likes to dislikes ratio
     *
     * @param mixed $n
     *
     * @return mixed
     */
    public function getTopChannelsByLikesToDislikesRatio($n)
    {
        $channelsData = $this->channelModel->getAllChannelsData();

        usort($channelsData, function ($a, $b) {
            $likesToDislikesRatioA = $a['likes'] / ($a['likes'] + $a['dislikes']);
            $likesToDislikesRatioB = $b['likes'] / ($b['likes'] + $b['dislikes']);

            return $likesToDislikesRatioB <=> $likesToDislikesRatioA;
        });

        return array_slice($channelsData, 0, $n);
    }
}
