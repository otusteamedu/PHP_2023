<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Domain\Enum;

enum Brackets: string
{
    case Default = '(';
    case Curly = '{';
    case Square = '[';

    /**
     * @return array<string>
     */
    public static function match(): array
    {
        return [
            self::Default->value => ')',
            self::Curly->value => '}',
            self::Square->value => ']',
        ];
    }
}
