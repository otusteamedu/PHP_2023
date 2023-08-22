<?php

declare(strict_types=1);

namespace App\News\Domain\Builder;

use App\News\Domain\Factory\NewsContentFactoryInterface;
use App\News\Domain\Orm\Category;
use App\News\Domain\Orm\News;
use App\News\Infrastructure\Repository\CategoryRepository;

final readonly class NewsBuilder
{
    public function __construct(
        private NewsContentFactoryInterface $contentFactory,
        private CategoryRepository $categoryRepository,
    ) {
    }

    private string $title;
    private string $author;
    private \DateTimeInterface $createAt;
    private Category $category;
    private string $text;

    public function setTitle(string $title): NewsBuilder
    {
        $this->title = $title;

        return $this;
    }

    public function setAuthor(string $author): NewsBuilder
    {
        $this->author = $author;

        return $this;
    }

    public function setCreateAt(\DateTimeInterface $createAt): NewsBuilder
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function setCategory(int $categoryId): NewsBuilder
    {
        $this->category = $this->categoryRepository->find($categoryId);

        return $this;
    }

    public function setText(string $text): NewsBuilder
    {
        $this->text = $text;

        return $this;
    }

    public function build(): News
    {
        $newsContent = $this->contentFactory->create($this->text);

        return (new News())
            ->setTitle($this->title)
            ->setAuthor($this->author)
            ->setCreatedAt($this->createAt)
            ->setCategory($this->category)
            ->setText($newsContent->getContent());
    }
}