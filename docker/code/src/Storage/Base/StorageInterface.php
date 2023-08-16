<?php

namespace IilyukDmitryi\App\Storage\Base;

interface StorageInterface
{
    public function getEventStorage(): EventStorageInterface;
}
