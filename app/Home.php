<?php

declare(strict_types=1);

namespace App;

class Home
{
    public function home(): void
    {
        echo $_SERVER['HOSTNAME'];
    }
}
