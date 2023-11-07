<?php

declare(strict_types=1);

namespace Gesparo\HW;

class EnvManager
{
    private const MYSQL_USER = 'MYSQL_USER';
    private const MYSQL_PASSWORD = 'MYSQL_PASSWORD';
    private const MYSQL_DATABASE = 'MYSQL_DATABASE';

    private array $envData;

    public static function getEnvParams(): array
    {
        return [
            self::MYSQL_USER,
            self::MYSQL_PASSWORD,
            self::MYSQL_DATABASE,
        ];
    }

    public function __construct(array $envData)
    {
        $this->envData = $envData;
    }

    public function getMysqlUser(): string
    {
        return $this->envData[self::MYSQL_USER];
    }

    public function getMysqlPassword(): string
    {
        return $this->envData[self::MYSQL_PASSWORD];
    }

    public function getMysqlDatabase(): string
    {
        return $this->envData[self::MYSQL_DATABASE];
    }
}
