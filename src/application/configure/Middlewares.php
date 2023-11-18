<?php

namespace src\application\configure;

use Slim\App;
use src\config\MiddlewaresConfig;

/**
 * @method get(string $string)
 */
class Middlewares
{
    public function add(App $app): void
    {
        foreach ($this->describes() as $describe) {
            $app->add($describe);
        }
    }

    private function describes(): array
    {
        return MiddlewaresConfig::describes();
    }
}
