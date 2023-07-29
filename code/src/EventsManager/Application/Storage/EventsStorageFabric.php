<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Storage;

use VKorabelnikov\Hw15\EventsManager\Application\Config\EventsConfigInterface;

class EventsStorageFabric
{
    public function getStorage(string $sStorageName, EventsConfigInterface $config): EventsStorageInterface
    {
        $className = "\\VKorabelnikov\\Hw15\\EventsManager\\Infrastructure\\" . $sStorageName . "EventsStorage";
        
        if (class_exists($className)) {
            return new $className($config);
        }

        throw new \Exception("Storage type not supported yet!");
    }
}
