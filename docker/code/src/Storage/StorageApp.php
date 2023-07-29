<?php

namespace IilyukDmitryi\App\Storage;

use Exception;
use IilyukDmitryi\App\Config\ConfigApp;
use IilyukDmitryi\App\Storage\Base\StorageInterface;

class StorageApp
{
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
        $host = $settings->getElasticHost();
        $port = $settings->getElasticPort();
        $user = $settings->getElasticUser();
        $pass = $settings->getElasticPass();

        $storage = new $storageClassName($host, $port, $user, $pass);
        if (!$storage instanceof StorageInterface) {
            throw new Exception("Storage error");
        }
        return $storage;
    }
}
