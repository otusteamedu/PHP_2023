<?php

declare(strict_types=1);

namespace Otus\App;

final class StringValidator
{
    public function isParenthesisValid(string $string): bool
    {
        if (empty($string)) {
            return false;
        }

        $stack = [];

        foreach (str_split($string) as $char) {
            if ($char === '(') {
                $stack[] = $char;
            } elseif ($char === ')') {
                $lastChar = array_pop($stack);

                if ($lastChar !== '(') {
                    return false;
                }
            } else {
                return false;
            }
        }

        return empty($stack);
    }
}
