<?php
declare(strict_types=1);

namespace Eevstifeev\Chat;

use RuntimeException;

class Config {
    private array $data;
    const FILE_NAME ='socket.ini';

    public function __construct() {
        $configFilePath = $_ENV['ROOT_DIR'] . '/config/' . self::FILE_NAME;
        if (!file_exists($configFilePath)) {
            throw new RuntimeException('Configuration file not found: ' . $configFilePath);
        }
        $this->data = parse_ini_file($configFilePath, true);
        if (!$this->data) {
            throw new RuntimeException('Invalid configuration file: ' . $configFilePath);
        }
    }

    public function get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        throw new RuntimeException('Configuration key not found: ' . $key);
    }
}
