<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

class App
{
    public function __construct()
    {}

    public function __invoke(): void
    {
        (new Route($_SERVER['REQUEST_URI']))->run();
    }
}
