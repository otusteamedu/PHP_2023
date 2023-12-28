<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class Config
{
    private string $host;
    private string $user;
    private string $password;
    private string $index;

    public function __construct()
    {
        if (!$config = parse_ini_file('.env')) {
            throw new RuntimeException('Не найден файл конфига');
        }

        if (!isset($config['ELASTIC_USERNAME']) || !isset($config['ELASTIC_PASSWORD']) || !isset($config['ELASTIC_INDEX']) || !isset($config['ELASTIC_HOST'])) {
            throw new RuntimeException('Не найдены переменные конфигурации');
        }

        $this->host = $config['ELASTIC_HOST'];
        $this->user = $config['ELASTIC_USERNAME'];
        $this->password = $config['ELASTIC_PASSWORD'];
        $this->index = $config['ELASTIC_INDEX'];

    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getIndex(): string
    {
        return $this->index;
    }
}
