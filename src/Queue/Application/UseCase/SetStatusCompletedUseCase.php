<?php

declare(strict_types=1);

namespace src\Queue\Application\UseCase;

use src\Queue\Domain\Repository\ElementRepositoryInterface;

class SetStatusCompletedUseCase
{
    public function __construct(private ElementRepositoryInterface $elementRepository)
    {
    }

    public function __invoke(string $uuid): void
    {
        $element = $this->elementRepository->get($uuid);
        $element->setStatus('completed');
        $this->elementRepository->add($element);
    }
}
