<?php

namespace src\application\configure;

use Slim\App;
use src\config\RoutesConfig;

/**
 * @method get(string $EventController)
 */
class Routes
{
    public function add(App $app): void
    {
        $routes = $this->describes();
        $posts = $routes['post'] ?? [];
        foreach ($posts as $post) {
            $app->post($post['pattern'], $post['callable']);
        }
    }

    private function describes(): array
    {
        return RoutesConfig::describes();
    }
}
