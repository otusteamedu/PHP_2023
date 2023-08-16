<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class EmptyStringException extends Exception implements UserExceptionInterface
{
    public function __construct()
    {
        parent::__construct('string is empty');
    }

    public function getUserMessage(): string
    {
        return 'Строка пустая';
    }
}