<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Normalizer;

use Otus\App\Youtube\Entity\Channel;

final class ChannelNormalizer
{
    public function normalize(Channel $channel): array
    {
        return [
            'id' => $channel->getId(),
            'name' => $channel->getName(),
            'description' => $channel->getDescription(),
            'likeCount' => $channel->getLikeCount(),
            'dislikeCount' => $channel->getDislikeCount(),
            'subscriberCount' => $channel->getSubscriberCount(),
        ];
    }
}
