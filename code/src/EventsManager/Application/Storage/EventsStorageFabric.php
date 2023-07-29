<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Storage;

use VKorabelnikov\Hw15\EventsManager\Application\Config\EventsConfigInterface;

class EventsStorageFabric
{
    const STORAGE_CLASSES_NAMESPACE = "\\VKorabelnikov\\Hw15\\EventsManager\\Infrastructure\\";
    const STORAGE_CLASSES_SUFFIX = "EventsStorage";

    public static function getStorage(string $sStorageName, EventsConfigInterface $config): EventsStorageInterface
    {
        $className = self::STORAGE_CLASSES_NAMESPACE . $sStorageName . self::STORAGE_CLASSES_SUFFIX;
        
        if (class_exists($className)) {
            return new $className($config);
        }

        throw new \Exception("Storage type not supported yet!");
    }
}
