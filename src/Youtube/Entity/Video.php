<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Entity;

final readonly class Video implements IdentifyInterface
{
    public function __construct(
        private string $id,
        private string $channelId,
        private string $title,
        private int $viewCount,
        private int $likeCount,
        private int $dislikeCount,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }
}
