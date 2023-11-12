<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Controller;

use Gesparo\HW\Application\UseCase\AddEventsUseCase;
use Gesparo\HW\Infrastructure\Request\AddEventRequestGetter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddController implements ControllerInterface
{
    private AddEventRequestGetter $addEventRequestGetter;
    private AddEventsUseCase $useCase;

    public function __construct(AddEventRequestGetter $addEventRequestGetter, AddEventsUseCase $useCase)
    {
        $this->addEventRequestGetter = $addEventRequestGetter;
        $this->useCase = $useCase;
    }

    /**
     * @return Response
     * @throws \JsonException
     */
    public function run(): Response
    {
        $eventsDTO = $this->addEventRequestGetter->getRequest();

        $this->useCase->add($eventsDTO);

        return new JsonResponse(['message' => 'Events added!']);
    }
}
