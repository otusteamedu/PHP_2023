<?php

namespace App\Controller;

use App\Dto\CreateEventDto;
use App\Dto\FindEventsDto;
use App\Service\EventService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route(('/event'))]
class EventController extends AbstractController
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }

    #[Route('/', name: 'create_event', methods: 'POST')]
    public function create(#[MapRequestPayload] CreateEventDto $createEventDto): Response
    {

        $this->eventService->create($createEventDto);

        return new Response();
    }

    #[Route('/clear', name: 'clear_events', methods: 'POST')]
    public function clear(): Response
    {
        $this->eventService->clear();

        return new Response();
    }

    #[Route('/find', name: 'find_events', methods: 'POST')]
    public function findByParams(#[MapRequestPayload] FindEventsDto $findEventsDto): JsonResponse
    {
        return $this->json($this->eventService->findMostSuitableByCondition($findEventsDto));
    }
}
