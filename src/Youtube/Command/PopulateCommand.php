<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Command;

use Otus\App\Elastic\Client;
use Otus\App\Youtube\Entity\Channel;
use Otus\App\Youtube\Normalizer\ChannelNormalizer;
use Otus\App\Youtube\Entity\Video;
use Otus\App\Youtube\Normalizer\VideoNormalizer;

final readonly class PopulateCommand implements CommandInterface
{
    public function __construct(
        private Client $client,
        private ChannelNormalizer $channelNormalizer,
        private VideoNormalizer $videoNormalizer,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function execute(): int
    {
        $channels = $this->generateChannels();
        $normalizedChannels = array_map($this->channelNormalizer->normalize(...), $channels);
        $videos = $this->generateVideos($channels);
        $normalizedVideos = array_map($this->videoNormalizer->normalize(...), $videos);

        $this->client->bulk('youtube-channels', $normalizedChannels);
        $this->client->bulk('youtube-videos', $normalizedVideos);

        return 0;
    }

    /**
     * @throws \Exception
     * @return array<Channel>
     */
    private function generateChannels(): array
    {
        $createChannel = fn (int $index) => new Channel(
            id: "channel_$index",
            name: "Channel $index",
            description: 'Description',
            likeCount: random_int(50_000, 1_000_000),
            dislikeCount: random_int(20_000, 80_000),
            subscriberCount: random_int(100_000, 500_000),
        );
        return array_map($createChannel, (range(0, 100)));
    }

    /**
     * @param array<Channel> $channels
     * @return array<Video>
     * @throws \Exception
     */
    private function generateVideos(array $channels): array
    {
        $createVideo = fn (int $index, int $likes, int $dislikes, Channel $channel) => new Video(
            id: "video_$index",
            channelId: $channel->getId(),
            title: "Video $index",
            viewCount: random_int(50_000, 999_999),
            likeCount: $likes,
            dislikeCount: $dislikes,
        );

        $videos = [];

        $maxVideos = random_int(50, 300);

        foreach ($channels as $channelIndex => $channel) {
            $likesPerVideo = floor($channel->getLikeCount() / $maxVideos);
            $remainingLikes = $channel->getLikeCount() % $maxVideos;

            $dislikesPerVideo = floor($channel->getDislikeCount() / $maxVideos);
            $remainingDislikes = $channel->getLikeCount() % $maxVideos;

            for ($i = 1; $i <= $maxVideos; $i++) {
                if ($remainingLikes > 0) {
                    $likesPerVideo++;
                    $remainingLikes--;
                }

                if ($remainingDislikes > 0) {
                    $dislikesPerVideo++;
                    $remainingDislikes--;
                }

                $videos[] = $createVideo(($channelIndex + 1) * $i, (int) $likesPerVideo, (int) $dislikesPerVideo, $channel);
            }
        }

        return $videos;
    }
}
