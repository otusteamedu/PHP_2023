<?php

declare(strict_types=1);

namespace App\Storage;

use App\Model\Event;

interface StorageInterface
{
    public function find(array $params);

    public function add(Event $event);

    public function clear();
}
