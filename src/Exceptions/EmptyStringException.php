<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Exceptions;

final class EmptyStringException extends \Exception
{
    protected $message = 'Строка пуста!';
}
