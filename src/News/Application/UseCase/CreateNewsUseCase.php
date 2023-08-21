<?php

declare(strict_types=1);

namespace App\News\Application\UseCase;

use App\News\Application\Dto\NewsDto;
use App\News\Domain\Builder\NewsBuilder;
use App\News\Domain\Contract\NewsRepositoryInterface;
use App\News\Domain\Notifier\NewsSubject;

final readonly class CreateNewsUseCase
{
    public function __construct(
        private NewsRepositoryInterface $repository,
        private NewsBuilder             $builder,
        private NewsSubject             $newsPublisher,
    ) {
    }

    public function create(NewsDto $newsDto): void
    {
        $newsBuilder = $this->builder
            ->setTitle($newsDto->getTitle())
            ->setAuthor($newsDto->getAuthor())
            ->setCreateAt($newsDto->getCreatedAt())
            ->setCategory($newsDto->getCategoryId())
            ->setText($newsDto->getText());

        $news = $newsBuilder->build();

        $this->repository->create($news);

        $this->newsPublisher->publishNews($news);;
    }
}
