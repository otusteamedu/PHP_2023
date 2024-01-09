<?php

declare(strict_types=1);

namespace App;

use App\Console\Dialog;

class App
{
    public function run(): void
    {
        $dialog = new Dialog();
        $dialog->execute();
    }
}
