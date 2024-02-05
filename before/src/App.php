<?php

declare(strict_types=1);

namespace App;

class App
{
    public function run(): void
    {
        Routes::chooseRoute();
    }
}
