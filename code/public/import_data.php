<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw11\YoutubeChannelAnalyzer\ElasticSearchConnection;

$elasticConnection = new ElasticSearchConnection();




$channelsAndVideosArray = [];
$channelsCount = 25;

for ($i = 1; $i <= $channelsCount; $i++) {
    $channelId = "channel" . $i;
    $channelLikesCount = 0;
    $channelDislikesCount = 0;

    $videosCount = rand(1, 15);
    for ($j = 1; $j <= $videosCount; $j++) {
        $videoId = $channelId . "_" . "video" . $j;

        $videoLikesCount = rand(0, 100);
        $channelLikesCount += $videoLikesCount;

        $videoDisikesCount = rand(0, 100);
        $channelDislikesCount += $videoDisikesCount;

        $channelsAndVideosArray[] = [
            'index' => [
                '_index' => "video2",
                '_id' => $videoId
            ]
        ];

        $channelsAndVideosArray[] = [
            "channel_id" => $channelId,
            "name" => "Name of video " . $videoId,
            "description" => "Description of video " . $videoId,
            "likes_count" => $videoLikesCount,
            "dislikes_count" => $videoDisikesCount
        ];
    }

    $channelsAndVideosArray[] = [
        'index' => [
            '_index' => "channel2",
            '_id' => $channelId
        ]
    ];
    $channelsAndVideosArray[] = [
        "channel_id" => $channelId,
        "name" => "Name of video " . $channelId,
        "description" => "Description of video " . $channelId,
        "likes_count" => $channelLikesCount,
        "dislikes_count" => $channelDislikesCount,
        "total_views" => $channelLikesCount + $channelDislikesCount + rand(1, 100)
    ];
}

$elasticConnection->bulk($channelsAndVideosArray);

echo "import finished";
