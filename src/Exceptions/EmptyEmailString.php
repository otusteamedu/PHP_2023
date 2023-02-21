<?php

declare(strict_types=1);

namespace Twent\EmailValidator\Exceptions;

use InvalidArgumentException;

final class EmptyEmailString extends InvalidArgumentException
{
    protected $message = 'Передан пустой email!';
    protected $code = 400;
}
