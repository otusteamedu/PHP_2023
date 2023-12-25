<?php

namespace WorkingCode\Hw6\Manager;

use WorkingCode\Hw6\Exception\ErrorReadIniFileException;
use WorkingCode\Hw6\Exception\SettingNotFoundInIniFileException;

class ConfigManager
{
    private const SETTINGS_PATH_FILE     = 'config.ini';
    private const SETTING_SECTION_SOCKET = 'socket';
    private const SETTING_SOCKET_PATH    = 'path';

    private array $settings;

    /**
     * @throws ErrorReadIniFileException
     */
    public function __construct()
    {
        $settings = parse_ini_file(self::SETTINGS_PATH_FILE, true);

        if (!$settings) {
            throw new ErrorReadIniFileException('error read ini file ' . self::SETTINGS_PATH_FILE);
        }

        $this->settings = $settings;
    }

    /**
     * @throws SettingNotFoundInIniFileException
     */
    public function getSocketPatch(): string
    {
        $socketPath = $this->settings[self::SETTING_SECTION_SOCKET][self::SETTING_SOCKET_PATH] ?? null;

        if ($socketPath === null) {
            throw new SettingNotFoundInIniFileException(printf(
                'Not found setting "%s" in section "%s"',
                self::SETTING_SOCKET_PATH,
                self::SETTING_SECTION_SOCKET
            ));
        }

        return $socketPath;
    }
}
