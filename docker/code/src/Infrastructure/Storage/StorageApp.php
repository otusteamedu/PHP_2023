<?php

namespace IilyukDmitryi\App\Infrastructure\Storage;

use Exception;
use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use IilyukDmitryi\App\Infrastructure\Storage\Base\EventStorageInterface;
use IilyukDmitryi\App\Infrastructure\Storage\Base\StorageInterface;

class StorageApp
{
    public static function getStorage(): StorageInterface
    {
        $settings = ConfigApp::get();
        $storageClassName = $settings->getNameStorage();
        if (!class_exists($storageClassName)) {
            throw new Exception("No exists Storage Class");
        }

        $storage = new $storageClassName();
        if (!$storage instanceof StorageInterface) {
            throw new Exception("Storage error");
        }
        return $storage;
    }
}
