<?php

declare(strict_types=1);

namespace Root\App\Application;

interface SettingsInterface
{
    public function get(string $key): mixed;
}
