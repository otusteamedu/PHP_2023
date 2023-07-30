<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Infrastructure\Config;

use VKorabelnikov\Hw15\EventsManager\Application\Config\ConfigInterface;
use VKorabelnikov\Hw15\EventsManager\Application\Dto\Config;

class IniConfig implements ConfigInterface
{
    public function getAllSettings(): Config
    {
        $sCongigFilePath = __DIR__ . "/../../../../config.ini";

        if (!file_exists($sCongigFilePath)) {
            throw new \Exception("Отсутствует файл настроек config.ini");
        }

        $settings = parse_ini_file($sCongigFilePath);
        
        $config = new Config();
        $config->redisConnectionScheme = $settings["redis_connection_scheme"];
        $config->redisConnectionHost = $settings["redis_connection_host"];
        $config->redisConnectionPort = $settings["redis_connection_port"];

        return $config;
    }
}