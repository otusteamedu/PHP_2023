<?php

declare(strict_types=1);

namespace Yalanskiy\Chat;

use RuntimeException;

/**
 * Class to get config.ini parameters
 */
class Config
{
    /**
     * Get config.ini parameter.
     * @param string $name
     *
     * @return string
     */
    public static function get(string $name): string
    {
        $ini = parse_ini_file('config.ini', true);
        if ($ini === false) {
            throw new RuntimeException("Error parse config.ini");
        }
        return $ini['chat'][$name] ?? '';
    }
}
