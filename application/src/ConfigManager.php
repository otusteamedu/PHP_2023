<?php

declare(strict_types=1);

namespace Gesparo\Hw;

class ConfigManager
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function hasSetting(string $settingName): bool
    {
        return array_key_exists($settingName, $this->config);
    }

    public function getSetting(string $settingName)
    {
        if (!$this->hasSetting($settingName)) {
            throw new \RuntimeException("Cannot find setting '$settingName' in the config");
        }

        return $this->config[$settingName];
    }
}