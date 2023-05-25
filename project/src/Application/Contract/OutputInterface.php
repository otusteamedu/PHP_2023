<?php

declare(strict_types=1);

namespace Vp\App\Application\Contract;

interface OutputInterface
{
    public function show($message): void;
}
