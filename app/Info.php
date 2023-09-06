<?php

declare(strict_types=1);

namespace App;

class Info
{
    public function getInfo(): void
    {
        phpinfo();

        phpinfo(INFO_MODULES);
    }
}