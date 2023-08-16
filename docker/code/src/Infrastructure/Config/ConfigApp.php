<?php

namespace IilyukDmitryi\App\Infrastructure\Config;

final class ConfigApp
{
    public static function get(): ?FileIni
    {
        static $config = null;
        
        if (null === $config) {
            $config = new FileIni();
        }
        return $config;
    }
}
