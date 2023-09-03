<?php

declare(strict_types=1);

namespace App\Validators;

use DomainException;

final class Parenthesis
{
    private const OPEN_PARENTHESIS = '(';
    private const CLOSE_PARENTHESIS = ')';

    /**
     * @throws DomainException
     */
    public static function validate(?string $value = null): void
    {
        if (!trim($value)) {
            throw new DomainException('Строка не может быть пустой.');
        }

        if (self::validateIsValueFromParentheses($value) === false) {
            throw new DomainException('Строка должна состоять из скобок.');
        }

        if (self::validateEqualCountOfParentheses($value) === false) {
            throw new DomainException('Неверное количество открытых и закрытых скобок.');
        }

        if (self::validateMatchedParentheses($value) === false) {
            throw new DomainException('Нельзя закрыть не открытую скобку.');
        }
    }

    private static function validateIsValueFromParentheses(string $value): bool
    {
        return str_replace([self::OPEN_PARENTHESIS, self::CLOSE_PARENTHESIS], '', $value) === "";
    }

    private static function validateEqualCountOfParentheses(string $value): bool
    {
        return substr_count($value, self::OPEN_PARENTHESIS) === substr_count($value, self::CLOSE_PARENTHESIS);
    }

    private static function validateMatchedParentheses(string $value): bool
    {
        $parenthesis = [];

        $length = strlen($value);
        for ($i = 0; $i < $length; $i++) {
            if ($value[$i] === self::OPEN_PARENTHESIS) {
                $parenthesis[] = self::OPEN_PARENTHESIS;
            } elseif (array_pop($parenthesis) !== self::OPEN_PARENTHESIS) {
                return false;
            }
        }

        return true;
    }
}
