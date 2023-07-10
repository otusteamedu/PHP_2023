<?php

declare(strict_types=1);

namespace Otus\App\Youtube\Command;

interface CommandInterface
{
    public function execute(): int;
}
