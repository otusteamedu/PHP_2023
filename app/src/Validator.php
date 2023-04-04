<?php

declare(strict_types=1);

namespace Imitronov\Hw5;

use Imitronov\Hw5\Exception\ValidationException;

interface Validator
{
    /**
     * @throws ValidationException
     */
    public function validate($value, $message = null): void;
}
