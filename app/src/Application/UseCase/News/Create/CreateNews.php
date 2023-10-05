<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Create;

use App\Application\Builder\NewsBuilder;
use App\Application\Observer\NewsIsCreatedEvent;
use App\Application\Observer\Publisher;
use App\Domain\Entity\News;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Flusher;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\Repository\Persister;
use App\Domain\Repository\UserRepositoryInterface;

final class CreateNews
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly NewsBuilder $newsBuilder,
        private readonly Persister $persister,
        private readonly Flusher $flusher,
        private readonly Publisher $publisher,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(CreateNewsInput $input): News
    {
        $category = $this->categoryRepository->firstOrFailById($input->getCategoryId());
        $author = $this->userRepository->firstOrFailById($input->getAuthorId());
        $id = $this->newsRepository->nextId();
        $now = new \DateTime();
        $news = $this
            ->newsBuilder
            ->setId($id)
            ->setCategory($category)
            ->setAuthor($author)
            ->setTitle($input->getTitle())
            ->setContent($input->getContent())
            ->setCreatedAt($now)
            ->setUpdatedAt($now)
            ->build();
        $this->persister->persist($news);
        $this->flusher->flush();

        $event = new NewsIsCreatedEvent($news);
        $this->publisher->notify($event);

        return $news;
    }
}
