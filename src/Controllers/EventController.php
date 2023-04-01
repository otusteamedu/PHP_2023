<?php

declare(strict_types=1);

namespace Twent\Hw12\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twent\Hw12\Services\EventManager;

final class EventController
{
    public function __construct(
        private readonly EventManager $eventManager = new EventManager(),
    ) {
    }

    public function index(Request $request): Response
    {
        return (new JsonResponse(['message' => 'Server works...']))
            ->setTtl(60);
    }

    public function create(Request $request): Response
    {
        $event = $this->eventManager->create($request);

        return new JsonResponse($event, 201);
    }

    public function show(Request $request, int $id): Response
    {
        $event = $this->eventManager->findById($id);

        return new JsonResponse($event);
    }

    public function findByConditions(Request $request): Response
    {
        $event = $this->eventManager->findByConditions($request);

        return new JsonResponse($event);
    }
}
