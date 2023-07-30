<?php

namespace IilyukDmitryi\App\Storage;

use Exception;
use IilyukDmitryi\App\Config\ConfigApp;
use IilyukDmitryi\App\Storage\Base\StorageInterface;

class StorageApp
{
    /**
     * @throws Exception
     */
    public static function get(): StorageInterface
    {
        static $storageApp = null;
        if (null === $storageApp) {
            $storageApp = static::getStorage();
        }
        
        return $storageApp;
    }
    
    private static function getStorage(): StorageInterface
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
