<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Controller;

use Gesparo\HW\Application\UseCase\GetEventUseCase;
use Gesparo\HW\Infrastructure\Request\GetRequestGetter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetController implements ControllerInterface
{
    private GetRequestGetter $requestGetter;
    private GetEventUseCase $useCase;

    public function __construct(GetRequestGetter $requestGetter, GetEventUseCase $useCase)
    {
        $this->requestGetter = $requestGetter;
        $this->useCase = $useCase;
    }

    /**
     * @return Response
     * @throws \JsonException
     */
    public function run(): Response
    {
        $conditions = $this->requestGetter->getConditions();
        $responseDTO = $this->useCase->get($conditions);

        if ($responseDTO->event === null) {
            return new JsonResponse([
                'event' => null,
            ]);
        }

        return new JsonResponse([
            'event' => [
                'event' => $responseDTO->event->name,
                'priority' => $responseDTO->event->priority,
                'conditions' => $responseDTO->event->conditions,
            ],
        ]);
    }
}
