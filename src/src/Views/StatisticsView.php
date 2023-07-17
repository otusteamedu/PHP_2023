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
 * Show statistics for a channel (total likes and dislikes)
 *
 * @param array $vars
 *
 * @return string
 */
/**
 * Display statistics for a channel
 *
 * @param array $data
 */
    public function showStatistics($data)
    {
        $channelId = $data['channel_id'];
        $totalLikes = $data['total_likes'];
        $totalDislikes = $data['total_dislikes'];

        echo "<strong>Statistics for Channel {$channelId}:</strong><br>";
        echo "Total Likes: {$totalLikes}<br>";
        echo "Total Dislikes: {$totalDislikes}<br>";
    }

    /**
     * Display top N channels by likes to dislikes ratio
     *
     * @param array $data
     *
     * @return void
     */
    public function topChannels($data)
    {
        $count = 0;
        foreach ($data as $channel) {
            $count++;
            echo "<strong># {$count}.</strong> ";
            $this->showStatistics($channel);
        }
    }

    /**
     * Generate a string with the total dislikes for a channel
     *
     * @param int $totalLikes
     *
     * @return string
     */
    public function getTotalDislikes($totalDislikes)
    {
        return "Total Dislikes: {$totalDislikes}";
    }

/**
 * Generate a string with the total likes for a channel
 *
 * @param int $totalLikes
 *
 * @return string
 */
    public function getTotalLikes($totalLikes)
    {
        return "Total Likes: {$totalLikes}";
    }
}
