<?php

declare(strict_types=1);

namespace App\Application\Builder;

use App\Domain\Entity\Category;
use App\Domain\Entity\News;
use App\Domain\Entity\User;
use App\Domain\ValueObject\Content;
use App\Domain\ValueObject\Id;
use App\Domain\ValueObject\NotEmptyString;

final class NewsBuilder
{
    private Id $id;

    private Category $category;

    private User $author;

    private NotEmptyString $title;

    private Content $content;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    public function build(): News
    {
        return new News(
            $this->id,
            $this->author,
            $this->category,
            $this->title,
            $this->content,
            $this->createdAt,
            $this->updatedAt,
        );
    }

    public function setId(Id $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function setTitle(NotEmptyString $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
