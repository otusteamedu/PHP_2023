<?php

namespace App\Models;

use Elasticsearch\Client;

class ChannelModel
{
    private $esClient;
    private $index = 'channels';

    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    public function addChannel($channelData)
    {
        $params = [
            'index' => $this->index,
            'body'  => $channelData,
        ];

        $response = $this->esClient->index($params);

        return $response['result'];
    }

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
<?php

namespace App\Models;

use Elasticsearch\Client;

class ChannelModel
{
    private $esClient;
    private $index = 'channels';

    public function __construct(Client $esClient)
    {
        $this->esClient = $esClient;
    }

    public function addChannel($channelData)
    {
        $params = [
            'index' => $this->index,
            'body'  => $channelData,
        ];

        $response = $this->esClient->index($params);

        return $response['result'];
    }

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
