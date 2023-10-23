<?php

declare(strict_types=1);

namespace App\Application\Contracts;

use App\Domain\Models\Event;

interface StorageInterface
{
    public function find(array $params);

    public function add(Event $event);

    public function clear();
}
