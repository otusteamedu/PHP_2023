<?php

declare(strict_types=1);

namespace Singurix\Chat;

class Stdout
{
    public static function printToConsole($message, $redColor = false): void
    {
        if ($redColor) {
            fputs(STDOUT, "\e[31m" . $message . "\e[39m\n");
        } else {
            fputs(STDOUT, $message . "\n");
        }
    }
}
