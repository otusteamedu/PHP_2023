<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Application\Storage;

use VKorabelnikov\Hw15\EventsManager\Application\Config\EventsConfigInterface;

//!!!!!!!!!!
use VKorabelnikov\Hw15\EventsManager\Infrastructure\IniConfig;

class EventsStorageFabric
{
    public function getStorage(string $sStorageName, EventsConfigInterface $config): EventsStorageInterface
    {
        $className = "\\VKorabelnikov\\Hw15\\EventsManager\\Infrastructure\\" . $sStorageName . "EventsStorage";
        var_dump($className);
        var_dump(class_exists("\\VKorabelnikov\\Hw15\\EventsManager\\Infrastructure\\RedisEventsStorage"));
        $ob = new \VKorabelnikov\Hw15\EventsManager\Infrastructure\RedisEventsStorage(new IniConfig());
        var_dump($ob);
        if (class_exists($sStorageName)) {
            return new $className($config);
        }

        throw new \Exception("Storage type not supported yet!");
    }
}
