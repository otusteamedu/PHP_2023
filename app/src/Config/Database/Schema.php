<?php

namespace Yakovgulyuta\Hw13\Config\Database;

use Nette\Schema\Expect;

class Schema
{
    public static function getConfigSchema(): array
    {
        return [
            'database' => Expect::structure([
                'driver' => Expect::anyOf('pgsql', 'mysql')->required(),
                'host' => Expect::string()->default('localhost'),
                'port' => Expect::int()->min(1)->max(65535),
                'ssl' => Expect::bool(),
                'database' => Expect::string()->required(),
                'username' => Expect::string()->required(),
                'password' => Expect::string()->nullable(),
            ]),
        ];
    }
}
