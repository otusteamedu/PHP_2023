<?php

declare(strict_types=1);

namespace App;

use App\Controllers\EventsController;
use App\Storage\RedisStorage;

class Routes
{
    public static function chooseRoute(): void
    {
        $storage = new RedisStorage();
        $controller = new EventsController($storage);

        switch ($_SERVER['REQUEST_URI']) {
            case '/add':
                $controller->add();
                break;
            case '/read':
                $controller->read();
                break;
            case '/clear':
                $controller->clear();
                break;
            default:
                echo 'Неподдерживаемый метод';
                break;
        }
    }
}
