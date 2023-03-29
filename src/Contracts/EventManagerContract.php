<?php

declare(strict_types=1);

namespace Twent\Hw12\Contracts;

use Twent\Hw12\DTO\Event;

interface EventManagerContract
{
    public function create(Event $event);
}
