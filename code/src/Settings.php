<?php

declare(strict_types=1);

namespace Application;

class Settings
{
    public static function getSettings(): array
    {
        return require __DIR__ . '/../config/config.php';
    }
}
