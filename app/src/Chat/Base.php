<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw6\Chat;

use DmitryEsaulenko\Hw6\Constants;
use DmitryEsaulenko\Hw6\Config;

abstract class Base
{
    protected const MESSAGE_LENGTH = 1500;

    protected Config $config;

    public function __construct()
    {
        $this->config = new Config();
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $configFile = ($_SERVER['DOCUMENT_ROOT'] ?: realpath(__DIR__) . '../../..') . Constants::CONFIG_PATH;
        $config = parse_ini_file($configFile);
        foreach ($config as $key => $value) {
            $this->config->set($key, $value);
        }
    }

    protected function getServerAddress(): string
    {
        return $this->config->get(Constants::SERVER_ADDRESS) ?? '';
    }
}
