<?php

/**
 * Класс, возвращающий конфигурацую
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\config;

class Config
{
    private static string $configEnvFile = __DIR__ . '/../../.env';
    private static string $configEnvExampleFile = __DIR__ . '/../../.env.example';
    private static array $config;

    public static function init()
    {
        if (file_exists(self::$configEnvFile)) {
            $fileArray = file(self::$configEnvFile);
            self::completeConfigArrayFromEnvFIle($fileArray);
            return;
        }

        if (file_exists(self::$configEnvExampleFile)) {
            $fileArray = file(self::$configEnvExampleFile);
            self::completeConfigArrayFromEnvFIle($fileArray);
        }
    }

    /**
     * @param string $key
     * @return mixed|string
     */
    public static function get(string $key)
    {
        return self::$config[$key] ?? '';
    }

    /**
     * @param array $fileArray
     * @return void
     */
    private static function completeConfigArrayFromEnvFIle(array $fileArray): void
    {
        foreach ($fileArray as $string) {
            if (empty(trim($string))) {
                continue;
            }
            $array = explode('=', $string);
            self::$config[strtolower($array[0])] = $array[1];
        }
    }
}
