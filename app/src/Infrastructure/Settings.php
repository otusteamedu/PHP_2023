<?php

declare(strict_types=1);

namespace Root\App\Infrastructure;

use Root\App\Application\SettingsInterface;

class Settings implements SettingsInterface
{
    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function get(string $key = ''): mixed
    {
        return (empty($key)) ? $this->settings : ($this->settings[$key] ?? null);
    }
}
