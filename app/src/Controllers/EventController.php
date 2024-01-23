<?php

declare(strict_types=1);

namespace Yevgen87\App\Controllers;

use Yevgen87\App\Services\EventService;

class EventController
{
    private EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    public function store(array $params)
    {
        if (!isset($params['priority']) or !isset($params['conditions']) or !isset($params['event'])) {
            return $this->response('Missing required params: priority, conditions or event', 400);
        }

        if (!is_integer((int)$params['priority'])) {
            return $this->response('Priority must be integer', 400);
        }

        if (!is_array($params['conditions'])) {
            return $this->response('Conditions must be array', 400);
        }

        if (!is_string($params['event'])) {
            return $this->response('Priority must be string', 400);
        }

        try {
            $this->eventService->store((int)$params['priority'], $params['conditions'], $params['event']);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), 500);
        }

        return $this->response('', 201);
    }

    public function get(array $params)
    {
        if (!isset($params['params'])) {
            return $this->response('Missing required params: params', 400);
        }

        $event = $this->eventService->getRelevant($params['params']);

        $text = $event
            ? 'Available event: ' . $event
            : 'Events are not available';

        $this->response($text);
    }

    public function delete()
    {
        $this->eventService->deleteAll();
        return http_response_code(204);
    }

    public function response($data, $code = 200)
    {
        http_response_code($code);
        echo json_encode($data);
    }
}
