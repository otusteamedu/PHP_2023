<?php

declare(strict_types=1);

namespace Vp\App\Services;

class Output
{
    public function show($message): void
    {
        fwrite(STDOUT, $message . PHP_EOL);
    }
}
