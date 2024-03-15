<?php

declare(strict_types=1);

namespace App\QueueClient\Rabbit;

use Exception;

class RabbitConfig implements RabbitConfigInterface
{
    private array $config;

    private string $host;
    private string $port;
    private string $user;
    private string $password;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->validatePathConfig();
        $this->validateVariableConfig();

        $this->host = $this->config['RABBITMQ_HOST'];
        $this->port = $this->config['RABBITMQ_PORT'];
        $this->user = $this->config['RABBITMQ_USER'];
        $this->password = $this->config['RABBITMQ_PASS'];
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
        if (!isset($this->config['RABBITMQ_HOST']) || !isset($this->config['RABBITMQ_PORT']) || !isset($this->config['RABBITMQ_USER']) || !isset($this->config['RABBITMQ_PASS'])) {
            throw new Exception('Не найдены переменные конфигурации');
        }
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
