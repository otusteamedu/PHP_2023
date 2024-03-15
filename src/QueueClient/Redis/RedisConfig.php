<?php

declare(strict_types=1);

namespace App\QueueClient\Redis;

use Exception;

class RedisConfig implements RedisConfigInterface
{
    private array $config;

    private string $host;
    private int $port;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->validatePathConfig();
        $this->validateVariableConfig();

        $this->host = $this->config['REDIS_HOST'];

        try {
            $this->port = (int)$this->config['REDIS_PORT'];
        } catch (Exception $e) {
            throw new Exception('Ошибка чтения порта'); // В случае ошибки преобразования в int
        }
    }

    /**
     * @throws Exception
     */
    private function validatePathConfig(): void
    {
        if (!file_exists(APP_PATH . '/.env')) {
            throw new Exception('Не найден файл конфига');
        }

        $this->config = parse_ini_file(APP_PATH . '/.env');
    }

    /**
     * @throws Exception
     */
    private function validateVariableConfig(): void
    {
        if (!isset($this->config['REDIS_HOST']) || !isset($this->config['REDIS_PORT'])) {
            throw new Exception('Не найдены переменные конфигурации');
        }
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }
}
