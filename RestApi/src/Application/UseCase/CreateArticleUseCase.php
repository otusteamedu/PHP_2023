<?php

namespace App\Application\UseCase;

use App\Application\Dto\ArticleDto;
use App\Application\Builder\ArticleBuilder;
use App\Application\Builder\Director;
use App\Domain\Contract\AuthorRepositoryInterface;
use App\Domain\Contract\CategoryRepositoryInterface;
use App\Domain\Entity\Article;

class CreateArticleUseCase
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
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

        return $articleBuilder->getResult();
    }
}
