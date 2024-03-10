<?php
declare(strict_types=1);

namespace RedisApp\Event;

class Event
{
    public function __construct(public $priority, public $conditions, public $event)
    {
    }
}