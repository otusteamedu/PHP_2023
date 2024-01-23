<?php

namespace App\Application\UseCase;

use App\Application\Dto\ArticleDto;
use App\Application\Builder\ArticleBuilder;
use App\Application\Builder\Director;
use App\Application\Notifier\ArticlePublisher;
use App\Domain\Contract\AuthorRepositoryInterface;
use App\Domain\Contract\CategoryRepositoryInterface;
use App\Domain\Entity\Article;

class CreateArticleUseCase
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly ArticlePublisher $articlePublisher,
    ) {
    }

    public function create(ArticleDto $articleDto): Article
    {
        $articleBuilder = new ArticleBuilder(
            $this->authorRepository,
            $this->categoryRepository
        );

        $director = new Director($articleBuilder);
        $director->constructArticle($articleDto);
        $article = $articleBuilder->getResult();
        $this->articlePublisher->publishNews($article);

        return $article;
    }
}
