<?php

declare(strict_types=1);

/**
 * Get values of config files
 */
function config(string $key): string
{
    return \Twent\Hw13\App::getConfigValue($key);
}
