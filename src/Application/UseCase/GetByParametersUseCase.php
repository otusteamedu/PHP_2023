<?php

declare(strict_types=1);

namespace src\Application\UseCase;

use src\Application\Repository\RepositoryInterface;
use src\Application\UseCase\Response\GetByParametersResponse;

class GetByParametersUseCase
{
    public function __construct(
        private RepositoryInterface $repository
    )
    {
    }

    public function __invoke(?int $param1, ?int $param2): ?GetByParametersResponse
    {
        $event = $this->repository->getByParameters($param1, $param2);

        if(!$event){
            return null;
        }
        return new GetByParametersResponse(
            priority: $event->getPriority(),
            param1: $event->getConditions()?->getParam1(),
            param2: $event->getConditions()?->getParam2(),
            event: $event->getEvent()
        );
    }
}
