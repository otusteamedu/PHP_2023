<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Config;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Config\ConfigInterface;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\Dto\Config;

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
            "connectionDbPassword",
            "rabbitConnectionHostName",
            "rabbitConnectionPort",
            "rabbitConnectionUser",
            "rabbitConnectionassword"
        ];

        $settings = parse_ini_file($sCongigFilePath);

        $config = new Config();
        foreach ($setingsNames as $setting) {
            $config->$setting = $settings[$setting];
        }

        return $config;
    }
}
