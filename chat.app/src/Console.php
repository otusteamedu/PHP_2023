<?php

declare(strict_types=1);

namespace Dshevchenko\Brownchat;

class Console
{
    public static function write(mixed $value = '', bool $newLineAfter = true): void
    {
        if ($value === null) {
            return;
        } elseif (is_string($value)) {
            $outValue = $value;
        } else {
            $outValue = (string)$value;
        }
        fwrite(STDOUT, $outValue . ($newLineAfter ? "\n" : ''));
    }

    public static function read(string $caption = ''): string
    {
        if ($caption !== '') {
            self::write($caption, false);
        }
        $message = fgets(STDIN);
        $message = trim($message);
        return $message;
    }
}
