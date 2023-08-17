<?php

declare(strict_types=1);

namespace Otus\SocketChat\Utils;

use Otus\SocketChat\Exception\{NotFoundConfigException, ParseConfigFileException};

class ConfigIni implements ConfigInterface
{
    private array $configs;

    public function init(): void
    {
        $configs = parse_ini_file('../config.ini');
        if ($configs === false) {
            throw new ParseConfigFileException();
        }
        $this->configs = $configs;
    }

    /**
     * @throws NotFoundConfigException
     */
    public function get(string $key): string
    {
        if (!isset($this->configs[$key])) {
            throw new NotFoundConfigException($key);
        }
        return $this->configs[$key];
    }
}