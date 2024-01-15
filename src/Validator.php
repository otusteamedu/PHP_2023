<?php

declare(strict_types=1);

namespace Santonov\Otus;

final class Validator
{
    public static function openedClosedBrackets(
        string $baseString,
        string $open = '(',
        string $close = ')'
    ): bool {
        $stack = [];
        for ($i = 0; $i < strlen($baseString); $i++) {
            if ($baseString[$i] === $open) {
                $stack[] = $baseString[$i];
                continue;
            }
            if ($baseString[$i] === $close) {
                if (count($stack) > 0 && $stack[count($stack) - 1] === $open) {
                    array_pop($stack);
                } else {
                    return false;
                }
            }
        }

        return count($stack) === 0;
    }
}
