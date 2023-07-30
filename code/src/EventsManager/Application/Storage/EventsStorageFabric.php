<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Storage;

use VKorabelnikov\Hw15\EventsManager\Application\Config\ConfigInterface;

class EventsStorageFabric
{
    const STORAGE_CLASSES_NAMESPACE = "\\VKorabelnikov\\Hw15\\EventsManager\\Infrastructure\\Storage\\";
    const STORAGE_CLASSES_SUFFIX = "EventsStorage";

    public static function getStorage(string $storageType, ConfigInterface $config): EventsStorageInterface
    {
        $className = self::STORAGE_CLASSES_NAMESPACE . $storageType . self::STORAGE_CLASSES_SUFFIX;
        
        if (class_exists($className)) {
            return new $className($config);
        }

        throw new \Exception("Еще не реализована поддержка хранилища " . $storageType . "!");
    }
}
