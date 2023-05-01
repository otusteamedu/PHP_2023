<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Application\Exceptions;

final class InvalidArgument extends \InvalidArgumentException
{
    /**
     * @var $code
     * @var string $message
     */
    protected $code = 400;
    protected $message = 'Строка не валидна!';
}
