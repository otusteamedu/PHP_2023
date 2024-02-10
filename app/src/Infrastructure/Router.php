<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure;

use DI\Container;
use Yevgen87\App\Infrastructure\Controllers\FilmController;

class Router
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if ($path == '/films') {
            $controller = $this->container->get(FilmController::class);

            $filmId = $_GET['film_id'] ?? null;

            if ($method == 'GET') {
                return $filmId
                    ? $controller->show((int)$filmId)
                    : $controller->index($_GET);
            }

            if ($method == 'POST') {
                return $filmId
                    ? $controller->update((int)$filmId, $_POST)
                    : $controller->store($_POST);
            }

            if ($method == 'DELETE' && $filmId) {
                return $controller->delete((int)$filmId);
            }
        }

        http_response_code(404);
    }
}
