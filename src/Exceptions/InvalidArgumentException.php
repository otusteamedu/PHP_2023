<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Exceptions;

final class InvalidArgumentException extends \InvalidArgumentException
{
    protected $code = 400;
    protected $message = 'Строка не валидна!';
}
