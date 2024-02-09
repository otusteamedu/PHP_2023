<?php

declare(strict_types=1);

namespace Yevgen87\App;

use Yevgen87\App\Infrastructure\FileSystemController;

class App
{
    public function run()
    {
        $controller = new FileSystemController;
        $controller($_SERVER['argv']);
    }
}
