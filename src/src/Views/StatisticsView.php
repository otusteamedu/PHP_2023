<?php

namespace App\Views;

/**
 * Class StatisticsView
 * 
 * @package App\Views
 */
class StatisticsView
{
    /**
     * Render total likes and dislikes for a channel
     * 
     * @param array $data
     * 
     * @return void
     */
    public function renderTotalLikesAndDislikesForChannel($data)
    {
        $channelData = $data['channel'];
        $likes = $data['likes'];
        $dislikes = $data['dislikes'];

        echo "Channel: {$channelData['channel_name']}\n";
        echo "Total Likes: {$likes}\n";
        echo "Total Dislikes: {$dislikes}\n";
    }

    /**
     * Render top N channels by likes to dislikes ratio
     * 
     * @param array $channelsData
     * 
     * @return void
     */
    public function renderTopChannelsByLikesToDislikesRatio($channelsData)
    {
        echo "Top Channels by Likes to Dislikes Ratio:\n";
        foreach ($channelsData as $channelData) {
            echo "Channel: {$channelData['channel_name']}\n";
            echo "Likes: {$channelData['likes']}\n";
            echo "Dislikes: {$channelData['dislikes']}\n";
            echo "\n";
        }
    }
}
