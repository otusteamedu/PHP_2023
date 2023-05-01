<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Application\Exceptions;

final class EmptyString extends \Exception
{
    /**
     * @var $code
     * @var string $message
     */
    protected $code = 400;
    protected $message = 'Строка пуста!';
}
