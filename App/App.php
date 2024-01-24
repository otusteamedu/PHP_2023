<?php

declare(strict_types=1);

namespace App;

use src\Infrastructure\Controller\RedisController;

class App
{
    public function run(array $argv): void
    {
        $controller = new RedisController();

        match ($argv[1]) {
            'add' => $controller->add($argv),
            'clear' => $controller->clear(),
            'get' => $controller->get($argv),
            'json' => $controller->fillWithBaseValuesFromJson()
        };
    }
}
