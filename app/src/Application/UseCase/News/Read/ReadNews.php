<?php

declare(strict_types=1);

namespace App\Application\UseCase\News\Read;

use App\Domain\Entity\News;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\NewsRepositoryInterface;

final class ReadNews
{
    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function handle(ReadNewsInput $input): News
    {
        return $this->newsRepository->firstOrFailById($input->getId());
    }
}
