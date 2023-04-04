<?php

declare(strict_types=1);

namespace Imitronov\Hw5;

use Imitronov\Hw5\Exception\RegExNotMatchValidationException;

final class RegExMatchValidator implements Validator
{
    private $regEx;

    public function __construct(string $regEx)
    {
        $this->regEx = $regEx;
    }

    public function validate($value, $message = null): void
    {
        $result = preg_match($this->regEx, $value);

        if (false === $result || 0 === $result) {
            throw new RegExNotMatchValidationException($message ?? 'Значение не соответствует регулярному выражению.');
        }
    }
}
