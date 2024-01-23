<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\Repository\RepositoryInterface;

class ClearAllEventUseCase
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    public function __invoke(): void
    {
        $this->repository->clearAllEvent();
    }
}
