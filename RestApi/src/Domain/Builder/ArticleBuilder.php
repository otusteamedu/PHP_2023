<?php

namespace App\Domain\Builder;

use App\Domain\Contract\EntityRepositoryInterface;
use App\Domain\Entity\Article;
use DateTimeInterface;

class ArticleBuilder implements BuilderInterface
{
    private Article $article;

    public function __construct(private EntityRepositoryInterface $entityRepository)
    {
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
        $author = $this->entityRepository->find($authorId);

        $this->article->setAuthor($author);
    }

    public function setCategories(array $categoriesId): void
    {

    }

    public function getResult(): Article
    {
        return $this->article;
    }
}
