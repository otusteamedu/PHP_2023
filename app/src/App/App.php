<?php

declare(strict_types=1);

namespace DEsaulenko\Hw13\App;

class App
{
    public function __construct() {
    }

    public function run(): void
    {
        dump($_ENV);
    }

}
