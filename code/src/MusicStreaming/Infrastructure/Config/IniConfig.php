<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Config;

use VKorabelnikov\Hw16\MusicStreaming\Application\Config\ConfigInterface;
use VKorabelnikov\Hw16\MusicStreaming\Application\Dto\Config;

class IniConfig implements ConfigInterface
{
    public function getAllSettings(): Config
    {
        $sCongigFilePath = __DIR__ . "/../../../../config.ini";

        if (!file_exists($sCongigFilePath)) {
            throw new \Exception("Отсутствует файл настроек config.ini");
        }

        $setingsNames = [
            "DBMSName",
            "connectionDbHost",
            "connectionDbPort",
            "connectionDbName",
            "connectionDbUser",
            "connectionDbPassword"
        ];

        $settings = parse_ini_file($sCongigFilePath);

        $config = new Config();
        foreach($setingsNames as $setting)
        {
            $config->$setting = $settings[$setting];
        }

        return $config;
    }
}