<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Vp\App\Exceptions\AddEventFailed;
use Vp\App\Exceptions\FindEventFailed;
use WS\Utils\Collections\Collection;

interface StorageInterface
{
    /**
     * @throws AddEventFailed
     */
    public function add(string $eventId, string $params, string $event): void;

    /**
     * @throws FindEventFailed
     */
    public function find(array $eventParams): ?Collection;

    public function delete(string $eventId): void;
}
