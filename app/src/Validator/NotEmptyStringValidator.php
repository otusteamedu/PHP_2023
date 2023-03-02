<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Validator;

use Imitronov\Hw4\Exception\ValidationException;

final class NotEmptyStringValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(mixed $data): void
    {
        if (!is_string($data)) {
            throw new ValidationException('Данные не являются строкой.');
        }

        if (mb_strlen(trim($data)) === 0) {
            throw new ValidationException('Строка пустая.');
        }
    }
}
