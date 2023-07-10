<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Entity;

final readonly class Channel implements IdentifyInterface
{
    public function __construct(
        private string $id,
        private string $name,
        private string $description,
        private int $likeCount,
        private int $dislikeCount,
        private int $subscriberCount,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    public function getSubscriberCount(): int
    {
        return $this->subscriberCount;
    }
}
