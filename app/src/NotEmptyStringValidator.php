<?php

declare(strict_types=1);

namespace Imitronov\Hw5;

use Imitronov\Hw5\Exception\EmptyStringValidationException;

final class NotEmptyStringValidator implements Validator
{
    public function validate($value, $message = null): void
    {
        if (is_string($value)) {
            $value = trim($value);
        }

        if (empty($value)) {
            throw new EmptyStringValidationException($message ?? 'Передано пустое значение.');
        }
    }
}
