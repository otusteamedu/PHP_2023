<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;

class News
{
    public function __construct(
        private Id $id,
        private User $author,
        private Category $category,
        private NotEmptyString $title,
        private Content $content,
        private \DateTimeInterface $createdAt,
        private \DateTimeInterface $updatedAt,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getTitle(): NotEmptyString
    {
        return $this->title;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
