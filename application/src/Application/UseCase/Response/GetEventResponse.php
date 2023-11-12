<?php

declare(strict_types=1);

namespace Gesparo\HW\Application\UseCase\Response;

use Gesparo\HW\Application\UseCase\Request\EventDTO;

class GetEventResponse
{
    public function __construct(public readonly ?EventDTO $event)
    {
    }
}
