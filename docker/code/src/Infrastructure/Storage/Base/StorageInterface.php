<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Base;

interface StorageInterface
{
    public function getEventStorage(): EventStorageInterface;
}
