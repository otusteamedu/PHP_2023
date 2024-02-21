<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\EventDTO;

interface AddEventInterface
{
    public function add(EventDTO $eventDTO): void;
}
