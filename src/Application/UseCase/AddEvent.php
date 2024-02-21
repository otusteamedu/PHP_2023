<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\EventDTO;
use App\Application\EntityBuilder\EventBuilder;
use App\Domain\Repository\StorageInterface;

readonly class AddEvent implements AddEventInterface
{
    public function __construct(
        private EventBuilder     $eventBuilder,
        private StorageInterface $storage,
    ) {
    }

    public function add(EventDTO $eventDTO): void
    {
        $event = $this->eventBuilder->buildFromEventDTO($eventDTO);
        $this->storage->add($event);
    }
}
