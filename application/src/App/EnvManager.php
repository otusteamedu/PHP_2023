<?php

declare(strict_types=1);

namespace Gesparo\HW\App;

class EnvManager
{
    public const ENV_MODE = 'MODE';
    public const ENV_PROVIDER = 'PROVIDER';

    public function getMode(): ?string
    {
        return $_ENV[self::ENV_MODE] ?? null;
    }

    public function getProvider(): ?string
    {
        return $_ENV[self::ENV_PROVIDER] ?? null;
    }
}
