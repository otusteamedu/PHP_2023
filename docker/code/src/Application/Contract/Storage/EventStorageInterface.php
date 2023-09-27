<?php

namespace IilyukDmitryi\App\Application\Contract\Storage;

use IilyukDmitryi\App\Application\Dto\Event;

interface EventStorageInterface
{
    public function setDone($uuid): bool;

    public function add(Event $event): bool;

    public function delete(string $uuid): bool;

    public function get(string $uuid): Event;

    public function list(int $limit = 0): array;
}
