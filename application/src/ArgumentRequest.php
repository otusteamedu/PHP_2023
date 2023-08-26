<?php

declare(strict_types=1);

namespace Gesparo\Hw;

class ArgumentRequest
{
    private array $arguments;

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getFirstArgument(): ?string
    {
        // first value is script name (like app.php)
        // so we take the next value that will be the first argument
        return $this->arguments[1] ?? null;
    }
}