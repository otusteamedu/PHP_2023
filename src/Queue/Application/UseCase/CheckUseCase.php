<?php

declare(strict_types=1);

namespace src\Queue\Application\UseCase;

use src\Queue\Domain\Repository\ElementRepositoryInterface;

class CheckUseCase
{
    public function __construct(private ElementRepositoryInterface $elementRepository)
    {
    }

    public function __invoke(string $uuid): string
    {
        $element = $this->elementRepository->get($uuid);
        return $element->getStatus();
    }
}
