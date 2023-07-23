<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw11\YoutubeChannelAnalyzer;

class ChannelStatistics
{
    protected $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection = new ElasticSearchConnection();
    }


    public function getChannelLikesAndDislikeCount(string $channelId): array
    {
        $res = $this->databaseConnection->searchDocument(
            'video',
            [
                "query" => [
                    "term" => [
                        "channel_id" => $channelId
                    ]
                ],
                "aggs" => [
                    "likes" => [
                        "sum" => [
                            "field" => "likes_count"
                        ]
                    ],
                    "dislikes" => [
                        "sum" => [
                            "field" => "dislikes_count"
                        ]
                    ]
                ]
            ]
        );


        return $res['aggregations'];
    }

    public function getBestChannelsList(int $count): array
    {
        $result = $this->databaseConnection->searchDocument(
            'channel',
            [
                "size" => $count,
                "sort" => [
                    "_script" => [
                        "type" => "number",
                        "script" => [
                            "lang" => "painless",
                            "source" => "(double)doc['likes_count'].value / (double) (doc['dislikes_count'].value + doc['likes_count'].value)"
                        ],
                        "order" => "desc"
                    ]
                ]
            ]
        );


        return $result['hits'];
    }
}
