<?php

namespace App\Application;

use App\Domain\Entity\Event;
use App\Domain\ValueObject\Conditions;

interface EventGatewayInterface
{
    public function add(Event $event): void;

    public function get(Conditions $conditions): ?Event;
}
