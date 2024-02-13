<?php

declare(strict_types=1);

namespace src\Queue\Application\UseCase;

use src\Queue\Application\Factory\ElementFactory;
use src\Queue\Application\UseCase\Request\AddElementQueueRequest;
use src\Queue\Domain\Repository\ElementRepositoryInterface;

class AddElementQueueUseCase
{
    public function __construct(
        private ElementFactory             $elementFactory,
        private ElementRepositoryInterface $elementRepository
    )
    {
    }

    public function __invoke(AddElementQueueRequest $request): string
    {
        $element = $this->elementFactory->fromAddElementQueueRequest($request);
        $this->elementRepository->add($element);
        return $element->getUuid();
    }
}
