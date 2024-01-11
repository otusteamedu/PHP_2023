<?php

namespace App\Application\Builder;

use App\Domain\Contract\AuthorRepositoryInterface;
use App\Domain\Contract\CategoryRepositoryInterface;
use App\Domain\Entity\Article;
use DateTimeInterface;

class ArticleBuilder implements BuilderInterface
{
    private Article $article;

    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function reset(): void
    {
        $this->article = new Article();
    }

    public function setName(string $name): void
    {
        $this->article->setName($name);
    }

    public function setCreationDate(DateTimeInterface $creationDate): void
    {
        $this->article->setCreationDate($creationDate);
    }

    public function setAuthor(int $authorId): void
    {
        $author = $this->authorRepository->find($authorId);

        $this->article->setAuthor($author);
    }

    /**
     * @param int[] $categoriesId
     */
    public function setCategories(array $categoriesId): void
    {
        $categories = $this->categoryRepository->findBy(['id' => $categoriesId]);

        foreach ($categories as $category) {
            $this->article->addCategory($category);
        }
    }

    public function setText(string $text): void
    {
        $this->article->setText($text);
    }

    public function getResult(): Article
    {
        return $this->article;
    }
}
