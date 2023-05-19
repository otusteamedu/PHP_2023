<?php

namespace Sva\Common\App;

use Dotenv\Dotenv;

class Env
{
    use \Sva\Singleton;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../../');
        $dotenv->load();
    }

    public function get(string $key): string
    {
        return $_ENV[$key];
    }
}
