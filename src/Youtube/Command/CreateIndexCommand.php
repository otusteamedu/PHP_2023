<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Command;

use Otus\App\Elastic\Client;

final readonly class CreateIndexCommand implements CommandInterface
{
    public function __construct(
        private Client $client,
    ) {
    }

    public function execute(): int
    {
        $this->createChannelIndex();
        $this->createVideoIndex();

        return 0;
    }

    private function createChannelIndex(): void
    {
        $channelFields = [
            'name' => [
                'type' => 'keyword'
            ],
            'description' => [
                'type' => 'text'
            ],
            'likeCount' => [
                'type' => 'integer'
            ],
            'dislikeCount' => [
                'type' => 'integer'
            ],
            'subscriberCount' => [
                'type' => 'integer'
            ],
        ];

        $this->client->createIndex('youtube-channels', $channelFields);
    }

    private function createVideoIndex(): void
    {
        $videoFields = [
            'title' => [
                'type' => 'text'
            ],
            'description' => [
                'type' => 'text'
            ],
            'channelId' => [
                'type' => 'keyword'
            ],
            'viewCount' => [
                'type' => 'integer'
            ],
            'likeCount' => [
                'type' => 'integer'
            ],
            'dislikeCount' => [
                'type' => 'integer'
            ]
        ];

        $this->client->createIndex('youtube-videos', $videoFields);
    }
}
