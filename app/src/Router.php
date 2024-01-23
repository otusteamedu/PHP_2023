<?php

declare(strict_types=1);

namespace Yevgen87\App;

use Yevgen87\App\Controllers\EventController;

class Router
{
    public function handle()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if ($path == '/events') {

            $controller = new EventController();

            if ($method == 'POST') {
                return $controller->store($_POST);
            }

            if ($method == 'GET') {
                return $controller->get($_GET);
            }

            if ($method == 'DELETE') {
                return $controller->delete();
            }
        }

        http_response_code(404);
    }
}
