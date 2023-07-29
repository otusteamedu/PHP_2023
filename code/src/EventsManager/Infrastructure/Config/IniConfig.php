<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Infrastructure\Config;

use VKorabelnikov\Hw15\EventsManager\Application\Config\ConfigInterface;

class IniConfig implements ConfigInterface
{
    public function getAllSettings(): array
    {
        $sCongigFilePath = __DIR__ . "/../../../../config.ini";

        if (!file_exists($sCongigFilePath)) {
            throw new \Exception("Отсутствует файл настроек config.ini");
        }

        return parse_ini_file($sCongigFilePath);
    }
}