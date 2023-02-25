<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Enums;

enum Brackets: string
{
    case Default = '(';
    case Curly = '{';
    case Square = '[';

    public static function match(): array
    {
        return [
            self::Default->value => ')',
            self::Curly->value => '}',
            self::Square->value => ']',
        ];
    }
}
