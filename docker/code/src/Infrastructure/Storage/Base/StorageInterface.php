<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Base;

use IilyukDmitryi\App\Application\Contract\Storage\EventStorageInterface;

interface StorageInterface
{
    public function getEventStorage(): EventStorageInterface;
}
