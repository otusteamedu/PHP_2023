<?php

declare(strict_types=1);

namespace Art\Code\Storage;

use Art\Code\Model\Event;

interface StorageInterface
{
    public function find(array $params);

    public function add(Event $event);

    public function clear();
}
