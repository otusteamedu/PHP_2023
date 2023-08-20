<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class ElasticRequestException extends Exception
{
    private const ERROR_MESSAGE = 'Ошибка запроса в БД';
    private const ERROR_MESSAGE_PATTERN = self::ERROR_MESSAGE . ': %s';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function clientError(string $message): self
    {
        return new self(sprintf(self::ERROR_MESSAGE_PATTERN, $message));
    }

    public static function serverError(): self
    {
        return new self(self::ERROR_MESSAGE);
    }
}