<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Controller;

use Gesparo\HW\Application\UseCase\ClearEventsUseCase;
use Gesparo\HW\Infrastructure\Storage\BaseStorageFacade;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ClearController implements ControllerInterface
{
    private ClearEventsUseCase $useCase;

    public function __construct(ClearEventsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @return Response
     */
    public function run(): Response
    {
        $this->useCase->clear();

        return new JsonResponse(['message' => 'Storage cleared']);
    }
}
