<?php

require __DIR__ . '/vendor/autoload.php';
use Elasticsearch\ClientBuilder;

$elasticsearchHost = $_ENV['ELASTICSEARCH_HOST'];
$elasticsearchPort = $_ENV['ELASTICSEARCH_PORT'];

// Create Elasticsearch client
$esClient = ClientBuilder::create()
    ->setHosts(["{$elasticsearchHost}:{$elasticsearchPort}"])
    ->build();

// Delete existing channels index
$deleteParams = [
    'index' => 'channels',
];
$esClient->indices()->delete($deleteParams);

// Delete existing videos index
$deleteParams = [
    'index' => 'videos',
];
$esClient->indices()->delete($deleteParams);

// Generate random channel data
$channelData = [];
for ($i = 1; $i <= 10; $i++) {
    $channelData[] = [
        'channel_id' => (string) $i,
        'channel_name' => 'Channel ' . $i,
    ];
}

// Generate random video data
$videoData = [];
for ($i = 1; $i <= 50; $i++) {
    $channelId = mt_rand(1, 10);
    $videoData[] = [
        'video_id' => (string) $i,
        'channel_id' => (string) $channelId,
        'video_title' => 'Video ' . $i,
        'likes' => mt_rand(0, 100),
        'dislikes' => mt_rand(0, 100),
    ];
}

// Index channel data
$indexParams = [
    'index' => 'channels',
    'body' => [],
];
foreach ($channelData as $channel) {
    $indexParams['body'][] = [
        'index' => [
            '_index' => $indexParams['index'],
            '_id' => $channel['channel_id'],
        ],
    ];
    $indexParams['body'][] = $channel;
}
$esClient->bulk($indexParams);

// Create video index with mapping
$videoIndexParams = [
    'index' => 'videos',
    'body' => [
        'mappings' => [
            'properties' => [
                'channel_id' => [
                    'type' => 'keyword'
                ],
                'likes' => [
                    'type' => 'integer'
                ],
                'dislikes' => [
                    'type' => 'integer'
                ]
            ]
        ],
        'settings' => [
            'index' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0
            ]
        ]
    ]
];

$esClient->indices()->create($videoIndexParams);

// Index video data
$indexParams = [
    'index' => 'videos',
    'body' => [],
];
foreach ($videoData as $video) {
    $indexParams['body'][] = [
        'index' => [
            '_index' => $indexParams['index'],
            '_id' => $video['video_id'],
            'routing' => $video['channel_id'],
        ],
    ];
    $indexParams['body'][] = $video;
}
$esClient->bulk($indexParams);

// Refresh the indices to make the data available for search immediately
$esClient->indices()->refresh(['index' => 'channels']);
$esClient->indices()->refresh(['index' => 'videos']);

// Perform a search query to retrieve the top 5 channels by likes
$searchParams = [
    'index' => 'videos',
    'body' => [
        'size' => 0,
        'aggs' => [
            'top_channels' => [
                'terms' => [
                    'field' => 'channel_id',
                    'size' => 5,
                    'order' => [
                        'total_likes' => 'desc'
                    ]
                ],
                'aggs' => [
                    'total_likes' => [
                        'sum' => [
                            'field' => 'likes'
                        ]
                    ],
                    'total_dislikes' => [
                        'sum' => [
                            'field' => 'dislikes'
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$response = $esClient->search($searchParams);

$topChannels = [];
foreach ($response['aggregations']['top_channels']['buckets'] as $bucket) {
    $channelId = $bucket['key'];
    $totalLikes = $bucket['total_likes']['value'];
    $totalDislikes = $bucket['total_dislikes']['value'];

    $topChannels[] = [
        'channel_id' => $channelId,
        'total_likes' => $totalLikes,
        'total_dislikes' => $totalDislikes,
    ];
}

print_r($topChannels);

echo "The database has been successfully populated with random values and top channels have been retrieved.";
