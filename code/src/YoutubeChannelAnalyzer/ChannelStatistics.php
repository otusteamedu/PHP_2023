<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw11\YoutubeChannelAnalyzer;

class ChannelStatistics {
    protected $databaseConnection;

    public function __construct() {
        $this->databaseConnection = new ElasticSearchConnection();
    }


    public function getChannelLikesAndDislikeCount(string $channelId) {
        $res = $this->databaseConnection->searchDocument(
            [
                'index' => 'video',
                'body' => [
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
            ]
        );

        // var_dump($res['hits']);
        var_dump($res['aggregations']);
        // return $res['aggregations']["likes"];
    }

    public function getBestChannelsList(int $count): array {
        $result = $this->databaseConnection->searchDocument(
            [
                'index' => 'channel',
                'body' => [
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
            ]
        );

        // var_dump($result['hits']);
        return $result['hits'];
    }
}
