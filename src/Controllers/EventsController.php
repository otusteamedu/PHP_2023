<?php

declare(strict_types=1);

namespace Ro\Php2023\Controllers;

use Ro\Php2023\Collections\Conditions;
use Ro\Php2023\Entities\Condition;
use Ro\Php2023\Entities\Event;
use Ro\Php2023\Storage\EventStorage;
use Ro\Php2023\Storage\EventStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsController implements EventsControllerInterface
{
    private EventStorage $eventStorage;

    public function __construct(EventStorageInterface $eventStorage)
    {
        $this->eventStorage = $eventStorage;
    }

    public function add(Request $request): Response
    {
        $body = $request->toArray();

        $conditions = new Conditions();
        foreach ($body['conditions'] as $key => $value) {
            $item = new Condition($key, $value);
            $conditions->add($item);
        }

        $event = new Event($body['priority'], $conditions, $body['event']);
        $res = $this->eventStorage->addEvent($event);

        return new Response($res);
    }

    public function getById(Request $request): Response
    {
        $id = $request->attributes->get('id');
        $res = $this->eventStorage->getById("event:{$id}");
        return new Response(json_encode($res));
    }

    public function getAll(): Response
    {
        $res = $this->eventStorage->getAll();
        return new Response(json_encode($res));
    }

    public function getMatching(Request $request): Response
    {
        $conditions = json_decode($request->getContent());

        $res = $this->eventStorage->getMatchingEvent($conditions);
        return new Response(json_encode($res));
    }

    public function delete(): Response
    {
        $res = $this->eventStorage->clearEvents();
        return new Response($res);
    }
}
