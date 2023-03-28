<?php

declare(strict_types=1);

namespace Aporivaev\Hw06;

class Hw06
{
    /**
     * @param array $list email
     * @return array<string, bool>
     */
    public static function emailValidation(array $list = []): array
    {
        $result = [];
        foreach ($list as $item) {
            $parts = explode('@', $item);
            if (count($parts) === 2) {
                $result[$item] = self::nameValidation($item) && self::mxValidation($parts[1]);
            } else {
                $result[$item] = false;
            }
        }

        return $result;
    }

    private static function nameValidation(string $string = null): bool
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
    }
    private static function mxValidation(string $string = null): bool
    {
        $hosts = [];
        return getmxrr($string, $hosts) === true;
    }
}
