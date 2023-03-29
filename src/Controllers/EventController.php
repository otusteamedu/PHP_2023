<?php

declare(strict_types=1);

namespace Twent\Hw12\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class EventController
{
    public function index(Request $request): Response
    {
        return (new JsonResponse(['data' => 'data']))/*->setTtl(60)*/;
    }

    public function show(Request $request, string $id): Response
    {
        return (new JsonResponse(['id' => $id, 'title' => "Event {$id}"]));
    }
}
