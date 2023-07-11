<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Controller;

use Imitronov\Hw12\Application\Presenter\EventPresenter;
use Imitronov\Hw12\Application\UseCase\Event\ClearEvents;
use Imitronov\Hw12\Application\UseCase\Event\CreateEvents;
use Imitronov\Hw12\Application\UseCase\Event\CreateEventsInput;
use Imitronov\Hw12\Application\UseCase\Event\SearchEvents;
use Imitronov\Hw12\Application\UseCase\Event\SearchEventsInput;
use Imitronov\Hw12\Infrastructure\Http\JsonResponse;

final class EventController
{
    public function create(
        CreateEventsInput $input,
        CreateEvents $createEvents,
        EventPresenter $eventPresenter,
    ): JsonResponse {
        $input->validate();
        $events = $createEvents->handle($input);

        return new JsonResponse(
            [
                'data' => array_map(
                    static fn ($event) => $eventPresenter->present($event),
                    $events,
                ),
            ],
            201,
        );
    }

    public function search(
        SearchEventsInput $input,
        SearchEvents $searchEvents,
        EventPresenter $eventPresenter,
    ): JsonResponse {
        $input->validate();
        $events = $searchEvents->handle($input);

        return new JsonResponse([
            'data' => array_map(
                static fn ($event) => $eventPresenter->present($event),
                $events,
            ),
        ]);
    }

    public function clear(ClearEvents $clearEvents): JsonResponse
    {
        $clearEvents->handle();

        return new JsonResponse([
            'result' => true,
        ]);
    }
}
