<?php

namespace Yakovgulyuta\Hw13\Config\Database;

class Params
{
    public static function getParams(): array
    {
        return [
            'database' => [
                'driver' => 'pgsql',
                'port' => 5432,
                'host' => 'postgres_otus',
                'database' => 'test',
                'username' => 'test',
                'password' => 'test',
            ],
        ];
    }
}
