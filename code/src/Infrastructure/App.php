<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure;

use Art\Code\Application\Helper\DotEnv;

class App
{
    public function run(): void
    {
        (new DotEnv(__DIR__ . '/../../.env'))->load();
        new RouteManager();
    }
}