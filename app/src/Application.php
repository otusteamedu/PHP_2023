<?php

declare(strict_types=1);

namespace Lebedev\App;

use Lebedev\App\Controller\BracketsController;

class Application
{
    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);

        if ((isset($uri[1]) && $uri[1] !== 'brackets') || !isset($uri[2])) {
            header("HTTP/1.1 404 Not Found");
            return;
        }

        $bracketsController = new BracketsController();
        $methodName = $uri[2] . 'Action';
        $bracketsController->$methodName();
    }
}
