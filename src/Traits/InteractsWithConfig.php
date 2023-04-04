<?php

declare(strict_types=1);

namespace Twent\Hw13\Traits;

use Twent\Hw13\Exceptions\Config\ConfigFileDoesntExists;
use Twent\Hw13\Exceptions\Config\ConfigKeyDoesntExists;
use Twent\Hw13\Exceptions\Config\InvalidConfigFile;
use Twent\Hw13\Exceptions\Config\InvalidConfigKey;
use Twent\Hw13\Exceptions\Config\InvalidConfigValue;

trait InteractsWithConfig
{
    /**
     * @throws InvalidConfigFile
     * @throws ConfigFileDoesntExists
     * @throws ConfigKeyDoesntExists
     * @throws InvalidConfigValue
     * @throws InvalidConfigKey
     */
    public static function getConfigValue(string $key): string
    {
        if (! $key) {
            throw new InvalidConfigKey();
        }

        $configKeys = explode('.', $key);

        $filename = array_shift($configKeys);
        $filename = "{$filename}.php";

        $fullConfigPath = self::$configPath . "/{$filename}";

        if (! file_exists($fullConfigPath)) {
            throw new ConfigFileDoesntExists($filename);
        }

        $config = include($fullConfigPath);

        if (! is_array($config)) {
            throw new InvalidConfigFile($filename);
        }

        while ($configKeys) {
            $key = array_shift($configKeys);

            if (! key_exists($key, $config)) {
                throw new ConfigKeyDoesntExists($key);
            }

            $config = $config[$key];
        }

        if (! is_string($config)) {
            throw new InvalidConfigValue();
        }

        return $config;
    }
}
