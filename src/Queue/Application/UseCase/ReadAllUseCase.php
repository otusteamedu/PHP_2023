<?php

declare(strict_types=1);

namespace src\Queue\Application\UseCase;

use src\Queue\Domain\Repository\ElementRepositoryInterface;

class ReadAllUseCase
{
    public function __construct(
        private ElementRepositoryInterface $elementRepository
    )
    {
    }

    public function __invoke(): array
    {
        return $this->elementRepository->readAll();
    }
}
