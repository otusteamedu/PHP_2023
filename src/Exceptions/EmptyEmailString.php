<?php

declare(strict_types=1);

namespace Twent\EmailValidator\Exceptions;

use Exception;

final class EmptyEmailString extends Exception
{
    protected $message = 'Передан пустой email!';
    protected $code = 400;
}
