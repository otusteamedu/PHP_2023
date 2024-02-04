<?php

declare(strict_types=1);

namespace Yevgen87\App;

class App
{
    public function run()
    {
        $router = new Router();
        $router->handle();
    }
}
