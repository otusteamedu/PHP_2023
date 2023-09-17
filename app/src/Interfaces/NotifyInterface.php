<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Interfaces;

interface NotifyInterface
{
    public function notify(string $text): void;
}
