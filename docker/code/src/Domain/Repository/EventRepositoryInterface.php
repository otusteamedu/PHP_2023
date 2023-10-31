<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Entity\Event;

interface EventRepositoryInterface
{
    public function getById(int $id):?Event;

    public function add(Event $event): int;
    public function update(Event $event): void;
    public function delete(int $id): void;
}