<?php

namespace App\Views;

class StatisticsView
{
    public function renderTotalLikesAndDislikesForChannel($data)
    {
        $channelData = $data['channel'];
        $likes = $data['likes'];
        $dislikes = $data['dislikes'];

        echo "Channel: {$channelData['channel_name']}\n";
        echo "Total Likes: {$likes}\n";
        echo "Total Dislikes: {$dislikes}\n";
    }

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
