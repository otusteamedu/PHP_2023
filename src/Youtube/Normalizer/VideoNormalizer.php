<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Normalizer;

use Otus\App\Youtube\Entity\Video;

final class VideoNormalizer
{
    public function normalize(Video $video): array
    {
        return [
            'id' => $video->getId(),
            'channelId' => $video->getChannelId(),
            'title' => $video->getTitle(),
            'viewCount' => $video->getViewCount(),
            'likeCount' => $video->getLikeCount(),
            'dislikeCount' => $video->getDislikeCount(),
        ];
    }
}
