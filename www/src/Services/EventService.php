<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis\Services;

use Yalanskiy\HomeworkRedis\EventInterface;

/**
 * EventService Class
 */
class EventService implements EventInterface
{
    private mixed $event;

    public function __construct(mixed $event)
    {
        $this->event = $event;
    }

    public function serialize(): string
    {
        if (is_string($this->event)) {
            return $this->event;
        }

        return json_encode($this->event);
    }

    public static function createFromString(string $eventString): self
    {
        $decoded = json_decode($eventString, true);
        if (empty($decoded)) {
            return new self($eventString);
        } else {
            return new self($decoded);
        }
    }

    public function print(): string
    {
        return print_r($this->event, true);
    }
}
