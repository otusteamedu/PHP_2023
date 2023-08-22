<?php

declare(strict_types=1);

namespace App\News\Application\Dto;

use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final readonly class NewsDto
{
    public function __construct(
        private string $title,
        private string $author,
        #[Context([DateTimeNormalizer::FORMAT_KEY => "Y-m-d H:i:s"])]
        private \DateTimeInterface $createdAt,
        private int $categoryId,
        private string $text,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
