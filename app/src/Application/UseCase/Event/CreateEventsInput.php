<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\UseCase\Event;

interface CreateEventsInput
{
    public function validate(): void;

    public function getEvents(): iterable;
}
