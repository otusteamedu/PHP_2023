<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw12\EventsManager;

use VKorabelnikov\Hw12\EventsManager\Storage\EventsStorage;
use VKorabelnikov\Hw12\EventsManager\Storage\RedisEventsStorage;

class Application
{
    public function getStorage(string $sStorageName): EventsStorage
    {
        if($sStorageName == "redis")
        {
            return new RedisEventsStorage($this->getRedisConnectionSettings());
        }
        
        throw new \Exception("Storage type not supported yet!");
    }

    protected function readConfigFile(): array
    {
        $sCongigFilePath = __DIR__ . "/../../config.ini";

        if (!file_exists($sCongigFilePath)) {
            throw new \Exception("Отсутствует файл настроек config.ini");
        }

        return parse_ini_file($sCongigFilePath);
    }

    protected function getRedisConnectionSettings(): array
    {
        $settings = $this->readConfigFile();

        if (!empty($settings["redis_connection_scheme"])) {
            $arRedisSettings["scheme"] = $settings["redis_connection_scheme"];
        } else {
            throw new \Exception("Не задан путь к файлу Unix сокета в config.ini");
        }

        if (!empty($settings["redis_connection_host"])) {
            $arRedisSettings["host"] = $settings["redis_connection_host"];
        } else {
            throw new \Exception("Не задан путь к файлу Unix сокета в config.ini");
        }

        if (!empty($settings["redis_connection_port"])) {
            $arRedisSettings["port"] = $settings["redis_connection_port"];
        } else {
            throw new \Exception("Не задан путь к файлу Unix сокета в config.ini");
        }
        
        return $arRedisSettings;
    }
}
