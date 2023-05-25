<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Contract;

interface OutputInterface
{
    public function show($message): void;
}
