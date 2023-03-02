<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Validator;

use Imitronov\Hw4\Exception\ValidationException;

final class BracketsValidator
{
    /**
     * @throws ValidationException
     */
    public function validate(mixed $data): void
    {
        if (!is_string($data)) {
            throw new ValidationException('Данные не являются строкой.');
        }

        $counter = 0;
        $stringLength = mb_strlen($data);

        for ($i = 0; $i < $stringLength; $i++) {
            $char = mb_substr($data, $i, 1);

            if ('(' === $char) {
                $counter++;
            }

            if (')' === $char) {
                $counter--;
            }

            if ($counter < 0) {
                throw new ValidationException('Строка некорректна.');
            }
        }

        if ($counter !== 0) {
            throw new ValidationException('Строка некорректна.');
        }
    }
}
