<?php

namespace App\Application\Builder;

use App\Application\Dto\ArticleDto;

class Director
{
    public function __construct(private readonly BuilderInterface $builder)
    {
    }

    public function constructArticle(ArticleDto $articleDto): void
    {
        $this->builder->reset();
        $this->builder->setName($articleDto->getName());
        $this->builder->setCreationDate($articleDto->getCreationDate());
        $this->builder->setAuthor($articleDto->getAuthorId());
        $this->builder->setCategories($articleDto->getCategoryIds());
        $this->builder->setText($articleDto->getText());
    }
}
