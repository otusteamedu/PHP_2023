<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console;

use Vp\App\Application\Contract\OutputInterface;

class Output implements OutputInterface
{
    public function show($message): void
    {
        fwrite(STDOUT, $message . PHP_EOL);
    }
}
