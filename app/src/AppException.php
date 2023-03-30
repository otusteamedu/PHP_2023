<?php

declare(strict_types=1);

namespace Aporivaev\Hw09;

use Exception;
use Throwable;

class AppException extends Exception
{
    private ?string $info = null;
    public function __construct(string $message, int $code = 0, ?string $info = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->info = $info;
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n\t{$this->info}\n\n";
    }
}
