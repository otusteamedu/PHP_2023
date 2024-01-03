<?php

namespace Common\Application\Helper;

class Str
{
    /**
     * Генерирует случайную строку
     * @param int $length
     * @param string $chars
     * @return string
     */
    public static function generateRandom(int $length = 32, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        $charsLength = strlen($chars);
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[rand(0, $charsLength - 1)];
        }

        return $result;
    }
}
