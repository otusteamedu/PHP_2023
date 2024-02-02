<?php

declare(strict_types=1);

namespace App;

use src\Infrastructure\Controller\TicketController;

class App
{
    public function run(array $argv)
    {
        $controller = new TicketController();

        match ($argv[1]) {
            'create' => $controller->create($argv),
            'get' => $controller->get($argv),
            'update' => $controller->update($argv),
            'delete' => $controller->delete($argv),
        };
    }
}
